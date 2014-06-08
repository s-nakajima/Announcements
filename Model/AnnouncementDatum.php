<?php
/**
 * AnnouncementDatum Model
 *
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for AnnouncementDatum Model
 */
class AnnouncementDatum extends AppModel {

	public $name = 'AnnouncementDatum';

	public $useTable = 'announcement_data';

	public $belongsTo = 'Announcement';

	public $isPublish = 1;

	//Model格納
	private $_Block = null;
	private $_Announcement = null;
	private $_AnnouncementBlock = null;
	private $_Frame = null;



   //状態
	public $type = array(
		'Publish'=>1,
		'PublishRequest'=>2,
		'Draft'=>3
	);

	public function getData($blockId , $lang,  $isSetting=null) {
		if(! $isSetting) {
			$this->getPublishData($blockId , $lang);
		}
		return $this->find('first' , array(
			'conditions' => array(
				'Announcement.block_id'=>$blockId,
				'AnnouncementDatum.language_id'=>$lang,
			),
			'order'=>'AnnouncementDatum.id DESC',
		));
	}

	public function getPublishData($blockId , $lang) {
		return $this->find('first' , array(
			'conditions' => array(
				'Announcement.block_id'=>$blockId,
				'AnnouncementDatum.language_id'=>$lang,
				'AnnouncementDatum.status_id'=>$this->isPublish,
			),
			'order'=>'AnnouncementDatum.id DESC'
		));
	}

	public function saveData($data , $userId, $roomId, $isAjax=0){
		//Modelセット
		$this->_setModel();

		//複合
		$isAjax = 1;
		$data = $this->_decodeContent($data , $isAjax);

		//status_idの設定
		$data = $this->_setStatus($data);

		//blockIdの設定
		$data = $this->_setBlockId($data , $userId, $roomId);

		//言語IDの設定
		$data = $this->_setLangId($data);

		//idなし。新規作成時
		if(! $data[$this->name]['id']) {
			unset($data[$this->name]['id']);
			$data[$this->name]['create_user_id'] = $userId;
		}
		else {
			$data[$this->name]['modified_user_id'] = $userId;
		}

		$d = $this->save($data);
		return $d;
	}

	//contentのdecode
	private function _decodeContent($data , $isAjax){
		if(! $isAjax) return $data;
		//decode
		$data[$this->name]['content'] = rawurldecode($data[$this->name]['content']);
		return $data;
	}
	//status_idを設定する
	private function _setStatus($data){
		$data[$this->name]['status_id'] = intval($this->type[$data[$this->name]['type']]);
		return $data;
	}
	//block_idの処理を行う
	private function _setBlockId($data , $userId, $roomId){
		//TODO:例外処理
		if(! $data[$this->name]['blockId']) {
			//blockIdをつくる
			$block = array();
			$d = array();
			$d['AnnouncementBlockBlock']['create_user_id'] = $userId;
			$d['AnnouncementBlockBlock']['room'] = $roomId;
			$block = $this->_Block->save($d);

			if($block){
				//AnnouncementBlock , Announsmentをつくる
				$d = array();
				$d['Announcement']['block_id'] = $block['AnnouncementBlockBlock']['id'];
				$d['Announcement']['create_user_id'] = $userId;
				$mine = $this->_Announcement->save($d);
				$data[$this->name]['announcement_id'] = $mine['Announcement']['id'];

				$d = array();
				$d['AnnouncementBlock']['block_id'] = $block['AnnouncementBlockBlock']['id'];
				$d['AnnouncementBlock']['create_user_id'] = $userId;
				$d['AnnouncementBlock']['announcement_id'] = $mine['Announcement']['id'];
				$myblock = $this->_AnnouncementBlock->save($d);


				//frameへ保存
				$d = array();
				$d['AnnouncementFrame']['id'] = $data[$this->name]['frameId'];
				$d['AnnouncementFrame']['block_id'] = $block['AnnouncementBlockBlock']['id'];
				$d['AnnouncementFrame']['modified_user_id'] = $userId;
				$myframe = $this->_Frame->save($d);
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

	private function _setModel(){
		$this->_Block = Classregistry::init("Announcements.AnnouncementBlockBlock");
		$this->_Announcement =  Classregistry::init("Announcements.Announcement");
		$this->_AnnouncementBlock = Classregistry::init("Announcements.AnnouncementBlock");;
		$this->_Frame = Classregistry::init("Announcements.AnnouncementFrame");
	}

	private function _setLangId($data){
		//langから、idを取得する //TODO:実装
		$data[$this->name]['language_id'] = 2;
		unset($data['lang']);
		return $data;
	}

}
