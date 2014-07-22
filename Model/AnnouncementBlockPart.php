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
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

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
 */
	public function updateParts($type, $frameId, $data, $userId) {
		$calName = '';
		if ($type == 'public') {
			$calName = 'edit_content';
		} elseif ($type == 'edit') {
			$calName = 'publish_content';
		}
		//frame情報取得
		//blockが無かった場合作成
			//blocks announcements_block_parts 両方作成
			//announcementsはここでは作成しない。
		//ルーム管理者の承認が必要確認
			//承認が必要な場合でpublishの場合は、空arrayを返す
		//変更可能パートの取得
		//$data[part_id]を配列に変換 : ,区切り
		//数字かどうかのチェックはバリデーションに任せる
		//更新処理 : $data[part_id]になかったものは0 あるものは1に更新

		//とりあえず。
		return $this->getList(1);
	}
}
