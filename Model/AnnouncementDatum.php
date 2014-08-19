<?php
/**
 * AnnouncementDatum Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for AnnouncementDatum Model
 */
class AnnouncementDatum extends AppModel {

/**
 * validation
 *
 * @var array
 */
	public $validate = array(
		'announcement_id' => array(
			'rule' => array(
				'numeric',
				'notEmpty'
			)
		),
		'status_id' => array(
			'rule' => array(
				'numeric',
				'notEmpty'
			)
		),
		'language_id' => array(
			'rule' => array(
				'numeric',
				'notEmpty'
			)
		),
		'create_user_id' => 'numeric',
		'modified_user_id' => 'numeric'
	);

/**
 * name
 *
 * @var string
 */
	public $name = 'AnnouncementDatum';

/**
 * table
 *
 * @var string
 */
	public $useTable = 'announcement_data';

/**
 * belongsTo
 *
 * @var string
 */
	public $belongsTo = 'Announcement';

/**
 * announcement_data.status_id 公開状態の設定値
 *
 * @var int
 */
	public $isPublish = 1;

/**
 * Blocks model object
 *
 * @var null
 */
	private $__Block = null;

/**
 * announcement model object
 *
 * @var null
 */
	private $__Announcement = null;

/**
 * frames model object
 *
 * @var null
 */
	private $__Frame = null;

/**
 * status type
 * constはarrayが扱えない....
 *
 * @var array
 */
	public $type = array(
		'Publish' => 1,
		'PublishRequest' => 2,
		'Draft' => 3,
		'Reject' => 4
	);

/**
 * 最新のデータを取得する
 *
 * @param int $blockId  blocks.id
 * @param string $lang  language_id
 * @param null $isSetting セッティングモードの状態 trueならon
 * @return array
 */
	public function getData($blockId, $lang, $isSetting = null) {
		if (! $isSetting) {
			$this->getPublishData($blockId, $lang);
		}
		return $this->find('first', array(
			'conditions' => array(
				'Announcement.block_id' => $blockId,
				'AnnouncementDatum.language_id' => $lang,
			),
			'order' => 'AnnouncementDatum.id DESC',
		));
	}

/**
 * 最新の公開情報を取得する。
 *
 * @param int $blockId blocks.id
 * @param int $lang  language_id
 * @return array
 */
	public function getPublishData($blockId, $lang) {
		return $this->find('first', array(
			'conditions' => array(
				'Announcement.block_id' => $blockId,
				'AnnouncementDatum.language_id' => $lang,
				'AnnouncementDatum.status_id' => $this->isPublish,
			),
			'order' => 'AnnouncementDatum.id DESC'
		));
	}

/**
 * 保存する
 *
 * @param array $data postされたデータ
 * @param int $frameId Frame.id
 * @param int $userId  users.id
 * @param bool $isEncode ajax通信かどうかの判定　ajax通信の場合はjavascript側でurlencodeされているため。
 * @return mixed null 失敗  array 成功
 */
	public function saveData($data, $frameId, $userId, $isEncode = null) {
		//Modelセット
		$this->__setModel();
		//例外処理をあとで追加する。
		$frame = $this->__getFrame($frameId, $userId);

		if (! $frame) {
			return null;
		}

		$blockId = $frame[$this->__Frame->name]['block_id'];

		//複合
		//$isEncode = 1;
		$data = $this->__decodeContent($data, $isEncode);

		//status_idの取得
		$statusId = $this->__getStatusId($data);

		//本体のIDを取得する
		$announcementId = $this->__Announcement->getByBlockId($blockId);
		if (! $announcementId || $announcementId < 1) {
			//なければ作成
			$announcementId = $this->__createAnnouncement($blockId, $userId);
		}
		//登録情報をつくる insert処理
		$this->create();
		$this->set('announcement_id', $announcementId);
		$this->set('create_user_id', $userId);
		$this->set('language_id', $data[$this->name]['langId']);
		$this->set('status_id', $statusId);
		$this->set('content', $data[$this->name]['content']);
		//保存結果を返す
		$rtn = $this->save();
		if ($data = $this->checkDataSave($rtn)) {
			//master
			$frame = $this->__Frame->findById($frameId);
			$rtn[$this->__Frame->name] = $frame[$this->__Frame->name];
			return $rtn;
		}
	}

/**
 * saveされたかどうかチェック
 *
 * @param array $rtn save data
 * @return mix array or null
 */
	public function checkDataSave($rtn) {
		if (is_array($rtn)
			&& isset($rtn[$this->name])
			&& isset($rtn[$this->name]['id'])
			&& $rtn[$this->name]['id']
		) {
			return $rtn;
		}
	}

/**
 * frameIdの存在確認
 *
 * @param int $frameId frames.id
 * @param int $userId  users.id
 * @return int
 */
	private function __getFrame($frameId, $userId) {
		$this->__setModel();
		//フレームIDのデータを取得する。
		$blockId = null;
		$frame = $this->__Frame->findById($frameId);
		if ($frame
			&& isset($frame[$this->__Frame->name])
			&& isset($frame[$this->__Frame->name]['block_id'])
		) {
			$blockId = $frame[$this->__Frame->name]['block_id'];
		}

		if ($frame && ! $blockId) {
			$data = array();
			$data[$this->__Block->name]['room_id'] = $frame[$this->__Frame->name]['room_id'];
			$data[$this->__Block->name]['created_user_id'] = $userId;

			$block = $this->__Block->save($data[$this->__Block->name]);
			//blockIdをframeに格納
			$frame[$this->__Frame->name]['block_id'] = $block[$this->__Block->name]['id'];
			$frame = $this->__Frame->save($frame);
		}
		return $frame;
	}

/**
 * Announcementのinsert処理
 *
 * @param int $blockId blocks.id
 * @param int $userId  users.id
 * @return int | null  announsments.id
 */
	private function __createAnnouncement($blockId, $userId) {
		$dd = array();
		$dd['Announcement']['block_id'] = $blockId;
		$dd['Announcement']['create_user_id'] = $userId;
		$rtn = $this->__Announcement->save($dd);
		return $rtn['Announcement']['id'];
	}

/**
 * Ajax通信用にエンコードされている本文をデコードする。
 *
 * @param array $data postされたデータ
 * @param bool $isEncode ajax判定
 * @return array mixed 加工されたデータ
 */
	private function __decodeContent($data, $isEncode) {
		if ($isEncode) {
			//decode
			$data[$this->name]['content'] = rawurldecode($data[$this->name]['content']);
		}
		return $data;
	}

/**
 * statusを設定する。
 *
 * @param array $data postされたデータ
 * @return array
 */
	private function __getStatusId($data) {
		$statusId = null;
		if (isset($this->type[$data[$this->name]['type']])
			&& $this->type[$data[$this->name]['type']]) {
			$statusId = intval($this->type[$data[$this->name]['type']]);
		}
		return $statusId;
	}

/**
 * model objectを格納する
 *
 * @return void
 */
	private function __setModel() {
		$this->__Block = Classregistry::init("NetCommons.NetCommonsBlock");
		$this->__Announcement = Classregistry::init("Announcements.Announcement");
		$this->__Frame = Classregistry::init("NetCommons.NetCommonsFrame");
	}
}
