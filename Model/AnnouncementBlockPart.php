<?php
/**
 * AnnouncementBlockPart Model
 *
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for AnnouncementBlockPart Model
 */
class AnnouncementBlockPart extends AppModel {

/**
 * frame
 *
 * @var class object
 */
	private $__Frame;

/**
 * room_parts
 *
 * @var class object
 */
	private $__RoomPart;

/**
 * __construct
 *
 * @param bool $id id
 * @param null $table db table
 * @param null $ds connection
 * @return void
 * @SuppressWarnings(PHPMD)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}

/**
 * ブロックの設定を取得する (全パート）
 *
 * @param int $blockId blocks.id
 * @return array
 */
	public function getList($blockId) {
		$rtn = $this->find('all', array(
			'conditions' => array(
				$this->name . '.block_id' => $blockId
			)
		));
		return $rtn;
	}

/**
 * blockIdからidを取得する
 *
 * @param int $blockId blocks.id
 * @param int $partId parts.id
 * @return array
 */
	public function findByBlockId($blockId, $partId) {
		$rtn = $this->find('first', array(
			'conditions' => array(
				$this->name . '.block_id' => $blockId,
				$this->name . '.part_id' => $blockId
			)
		));
		return $rtn;
	}

/**
 * ブロックIDからidを取得する
 *
 * @param int $blockId blocks.id
 * @param int $partId parts.id
 * @return null
 */
	public function getIdByBlockId($blockId, $partId) {
		$block = $this->findByBlockId($blockId, $partId);
		if ($block
			&& isset($block[$this->name])
			&& isset($block[$this->name]['id'])
			&& $block[$this->name]['id']
		) {
			return $block[$this->name]['id'];
		}
		return null;
	}

/**
 * blockの権限更新
 *
 * @param string $type edit or publish
 * @param int $frameId frames.id
 * @param array $data  post array
 * @param int $userId  users.id
 * @return array
 * @SuppressWarnings(PHPMD)
 */
	public function updateParts($type, $frameId, $data, $userId) {
		$this->setDataSource('master');
		$this->__setModel();
		//全てmasterを見る
		$this->setDataSource('master');
		$this->__Frame->setDataSource('master');
		$this->__RoomPart->setDataSource('master');

		//postされたframe_idとgetで渡されてるframeIdが違うなら処理しない
		if (! $data
			|| ! isset($data["part_id"])
			|| (! isset($data['frame_id']) || $frameId != $data['frame_id'])
		) {
			//処理せず終了
			return array();
		}

		//frame情報取得
		if (! $frame = $this->__Frame->findById($frameId) ) {
			return array();
		}

		//配列からblockのidを取得する
		$blockId = $this->getBlockIdByFrame($frame, $userId);
		if ($blockId == 0) {
			$block = $this->__Frame->createBlock($frameId, $userId);
			if (isset($block['AnnouncementBlock'])
				&& isset($block['AnnouncementBlock']['id'])
			) {
				$blockId = $block['AnnouncementBlock']['id'];
			} else {
				return array();
			}
		}

		//元データの取得 : 無ければ初期値をinsert処理を実行する
		//blockが無かった場合作成。
		//トランザクションの開始 insert処理してるから。
		$blockParts = $this->createBlockPart($blockId, $userId);

		//part_idを配列にする。ここに格納されているものは権限が付与されたもの。
		//可変の項目で、ここにpart_idが含まれていないものは0を格納し権限を剥奪する。
		//$data[part_id]を配列に変換 : ,区切り
		//更新処理 : $data[part_id]になかったものは0 あるものは1に更新
		$data['part_id'] = explode(',', $data['part_id']);

		//可変可能なidの取得
		if ($type == 'publish') {
			$abilityName = 'edit_content';
		} elseif ($type == 'edit') {
			$abilityName = 'publish_content';
		} else {
			//ロールバック
			return array();
		}
		$partIdList = $this->__RoomPart->getVariableListPartIds($abilityName);
		//更新処理
		foreach ($blockParts as $item) {
			if (isset($partIdList[$item[$this->name]['part_id']]) //可変可能である事
			) {
				if (in_array($item[$this->name]['part_id'], $data['part_id'])) {
					//可変であること
					//$data['part_id']に含まれている場合は1がセットされる
					$item[$abilityName] = 1;
				} else {
					//含まれない場合は0がセットされる
					$item[$abilityName] = 0;
				}
				//updateに必要な情報をセット
				unset($item[$this->name]['modified']);
				$item[$this->name]['modified_user_id'] = $userId;
				//更新を実行する
				if (! $this->save($item[$this->name])) {
					//ロールバック
					return array();
				}
			}
		}
		//commit
		return $this->getList($blockId);
	}

/**
 * block partの新規作成 : デェフォルト値でinsert処理を実行する
 *
 * @param int $blockId blocks.id
 * @param int $userId  users.id
 * @return array|null
 */
	public function createBlockPart($blockId, $userId) {
		if (! $blockId) {
			return null;
		}
		//modelが設定されていなければ設定する。
		if (! $this->__RoomPart) {
			$this->__setModel();
		}
		$this->setDataSource('master');
		$this->__Frame->setDataSource('master');
		$this->__RoomPart->setDataSource('master');

		$blockPart = $this->find('all',
			array(
				'conditions' => array(
					$this->name . ".block_id" => $blockId
				)
			)
		);
		//すでにある値を返す
		if ($blockPart) {
			return $blockPart;
		}
		//1件も無いなら、insertし作成する
		//デェフォルトの取得
		$default = $this->__RoomPart->getBlockPartConfig($blockId, $userId);
		if ($this->saveAll($default)) {
			return $this->getList($blockId);
		}
	}

/**
 * frame 配列からblock_idを取得する。
 *
 * @param array $frame frames recode
 * @param int $userId user.id
 * @return int or null
 */
	public function getBlockIdByFrame($frame, $userId) {
		if ( $frame && isset($frame[$this->__Frame->name])
			&& isset($frame[$this->__Frame->name]['block_id'])
		) {
			return $frame[$this->__Frame->name]['block_id'];
		}
	}

/**
 * model objectを格納する
 *
 * @return void
 */
	private function __setModel() {
		//$this->__Block = Classregistry::init("Announcements.AnnouncementBlock");
		//$this->__Announcement = Classregistry::init("Announcements.Announcement");
		//$this->__AnnouncementBlock = Classregistry::init("Announcements.AnnouncementBlock");
		$this->__Frame = Classregistry::init("Announcements.AnnouncementFrame");
		$this->__RoomPart = Classregistry::init("Announcements.AnnouncementRoomPart");
	}
}
