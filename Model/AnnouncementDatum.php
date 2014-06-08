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
 * announcement_blocks model object
 *
 * @var null
 */
	private $__AnnouncementBlock = null;

/**
 * frames model object
 *
 * @var null
 */
	private $__Frame = null;

/**
 * status type
 *
 * @var array
 */
	public $type = array(
		'Publish' => 1,
		'PublishRequest' => 2,
		'Draft' => 3
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
 * @param int $userId  User.id
 * @param int $roomId  room_id
 * @param bool $isAjax ajax判定
 * @return array
 */
	public function saveData($data, $userId, $roomId, $isAjax = false) {
		//Modelセット
		$this->__setModel();

		//複合
		$isAjax = 1;
		$data = $this->__decodeContent($data, $isAjax);

		//status_idの設定
		$data = $this->__setStatus($data);

		//blockIdの設定
		$data = $this->__setBlockId($data, $userId, $roomId);

		//言語IDの設定
		$data = $this->__setLangId($data);

		//idなし。新規作成時
		if (! $data[$this->name]['id']) {
			unset($data[$this->name]['id']);
			$data[$this->name]['create_user_id'] = $userId;
		} else {
			$data[$this->name]['modified_user_id'] = $userId;
		}
		$d = $this->save($data);
		return $d;
	}

/**
 * Ajax通信用にエンコードされている本文をデコードする。
 *
 * @param array $data postされたデータ
 * @param bool $isAjax ajax判定
 * @return array mixed 加工されたデータ
 */
	private function __decodeContent($data, $isAjax) {
		if (! $isAjax) {
			return $data;
		}
		//decode
		$data[$this->name]['content'] = rawurldecode($data[$this->name]['content']);
		return $data;
	}

/**
 * statusを設定する。
 *
 * @param array $data postされたデータ
 * @return array
 */
	private function __setStatus($data) {
		$data[$this->name]['status_id'] = intval($this->type[$data[$this->name]['type']]);
		return $data;
	}

/**
 * block_idを設定する
 *
 * @param array $data postされたデータ
 * @param int $userId user_id
 * @param int $roomId room_id
 * @return array
 */
	private function __setBlockId($data, $userId, $roomId) {
		if (! $data[$this->name]['blockId']) {
			//blockIdをつくる
			$block = array();
			$d = array();
			$d['AnnouncementBlockBlock']['create_user_id'] = $userId;
			$d['AnnouncementBlockBlock']['room'] = $roomId;
			$block = $this->__Block->save($d);

			if ($block) {
				//AnnouncementBlock , Announsmentをつくる
				$d = array();
				$d['Announcement']['block_id'] = $block['AnnouncementBlockBlock']['id'];
				$d['Announcement']['create_user_id'] = $userId;
				$mine = $this->__Announcement->save($d);
				$data[$this->name]['announcement_id'] = $mine['Announcement']['id'];

				$d = array();
				$d['AnnouncementBlock']['block_id'] = $block['AnnouncementBlockBlock']['id'];
				$d['AnnouncementBlock']['create_user_id'] = $userId;
				$d['AnnouncementBlock']['announcement_id'] = $mine['Announcement']['id'];
				$myblock = $this->__AnnouncementBlock->save($d);

				//frameへ保存
				$d = array();
				$d['AnnouncementFrame']['id'] = $data[$this->name]['frameId'];
				$d['AnnouncementFrame']['block_id'] = $block['AnnouncementBlockBlock']['id'];
				$d['AnnouncementFrame']['modified_user_id'] = $userId;
				$myframe = $this->__Frame->save($d);
				unset($data[$this->name]['frameId']);
			}
			$data[$this->name]['block_id'] = $block['AnnouncementBlockBlock']['id'];
		} else {
			//announcement_idの取得
			$data[$this->name]['announcement_id'] = 1;
			$data[$this->name]['block_id'] = $data[$this->name]['blockId'];
		}
		unset($data[$this->name]['blockId']);
		return $data;
	}

/**
 * model objectを格納する
 *
 * @return void
 */
	private function __setModel() {
		$this->__Block = Classregistry::init("Announcements.AnnouncementBlockBlock");
		$this->__Announcement = Classregistry::init("Announcements.Announcement");
		$this->__AnnouncementBlock = Classregistry::init("Announcements.AnnouncementBlock");
		$this->__Frame = Classregistry::init("Announcements.AnnouncementFrame");
	}

/**
 * 言語IDを取得する。
 *
 * @param array $data postされたデータ
 * @return array
 */
	private function __setLangId($data) {
		//langから、idを取得する とりあえず固定
		$data[$this->name]['language_id'] = 2;
		unset($data['lang']);
		return $data;
	}

}
