<?php
/**
 * AnnouncementsAppController
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AppController', 'Controller');
App::uses('NetCommonsPluginComponent', 'NetCommons.Controller/Component');

class AnnouncementsAppController extends AppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
		'Announcements.AnnouncementDatum',
		'Announcements.AnnouncementBlockPart',
		'NetCommons.NetCommonsPartsRoomsUser',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomPart',
		'NetCommons.NetCommonsRoom',
		'NetCommons.NetCommonsBlock',
	);

/**
 * components
 * @var array
 */
	public $components = array(
		'DebugKit.Toolbar',
		'Session',
		'Asset',
		'Auth' => array(
			'loginAction' => array(
				'plugin' => 'auth',
				'controller' => 'auth',
				'action' => 'login',
			),
			'loginRedirect' => array(
				'plugin' => 'pages',
				'controller' => 'pages',
				'action' => 'index',
			),
			'logoutRedirect' => array(
				'plugin' => 'auth',
				'controller' => 'auth',
				'action' => 'login',
			)
		),
		'RequestHandler',
		'Security',
		'NetCommons.NetCommonsPlugin'
	);

/**
 * need Approval for room`s contents.
 * ルーム管理者の承認が必要かどうかのルームの設定
 * 初期値はより厳しい設定にするべきなのでtureを初期値としている。
 *
 * @var bool
 */
	public $isNeedApproval = true;

/**
 * room admin
 *
 * @var bool
 */
	public $isRoomAdmin = false;

/**
 * ブロックの編集権限
 *
 * @var bool
 */
	public $isBlockEdit = false;

/**
 * frameId
 *
 * @var int
 */
	public $frameId = 0;

/**
 * block id
 *
 * @var int
 */
	public $blockId = 0;

/**
 * room id
 *
 * @var int
 */
	public $roomId = 0;

/**
 * 言語ID
 *
 * @var int
 */
	public $langId = 2;

/**
 * 言語
 *
 * @var string
 */
	public $lang = 'ja';

/**
 * users.id
 *
 * @var int
 */
	public $userId = 0;

/**
 * コンテンツの編集権限
 *
 * @var bool
 */
	public $isEdit = false;

/**
 * ルーム内での公開権限
 *
 * @var bool
 */
	public $isPublish = false;

/**
 * ルーム内での権限
 * room_parts と parts_rooms_usersが1レコード分格納される。
 *
 * @ver array
 */
	public $roomPart = array();

/**
 * セッティングモードの状態
 *
 * @var bool
 */
	public $isSetting = false;

/**
 * frame 取得とそこからの諸々設定
 *
 * @param int $frameId flames.id
 * @return mixed
 */
	protected function _setFrame($frameId) {
		//frameの情報を取得する
		$frame = $this->NetCommonsPlugin->setFrameId($this, $frameId);
		//frameの情報から、諸々設定値を書く王する。
		if ($frame) {
			//edit_contentの権限を確認する
			$this->__setEdit($this->NetCommonsPlugin->roomPart);
			//publish_content コンテンツの公開権限を確認し、設定する。
			//contentの権限は、プラグイン側での判断になるため、共通処理にはなっていない。
			//room_partsよりきつい制限を設ける事が出来る。
			$this->setPublishContent();
		}
		//block別のpart設定を取得し設定する。
		$this->__setBlockPartList();

		//frameの情報を返す
		return $frame;
	}

/**
 * コンテンツの公開権限を確認し格納する。
 *
 * @return bool
 */
	public function setPublishContent() {
		$this->set('isPublish', false); //初期値
		$columnName = 'publish_content';
		$rtn = $this->__checkPartSetting($this->roomPart, $columnName);
		if ($this->isNeedApproval && $this->isRoomAdmin) {
			//ルーム管理者の承認がひつようで、ルーム管理者
			$this->isPublish = $rtn;
			$this->set('isPublish', $this->isPublish);
			return $this->isPublish;
		} elseif ($this->isNeedApproval && ! $this->isRoomAdmin) {
			//ルーム管理者の承認がひつようで、ルーム管理者以外 不許可
			$this->isPublish = false;
			$this->set('isPublish', $this->isPublish);
			return $this->isPublish;
		} else {
			//ルーム管理者の承認が不要 設定による。
			$this->isPublish = $rtn;
			$this->set('isPublish', $this->isPublish);
			return $this->isPublish;
		}
	}

/**
 * 権限チェック
 *
 * @param array $roomPart room part
 * @param string $columnName チェックしたいカラム
 * @return bool
 * @SuppressWarnings(PHPMD)
 */
	private function __checkPartSetting($roomPart, $columnName) {
		$RoomsUserName = "NetCommonsPartsRoomsUser";
		$roomPartName = 'RoomPart';
		if (! $roomPart
			|| ! isset($roomPart[$roomPartName]) || ! isset($roomPart[$RoomsUserName]) || ! isset($roomPart[$RoomsUserName]['part_id'])
			|| (isset($roomPart[$roomPartName][$columnName]) && $roomPart[$roomPartName][$columnName] == 0)
		) {
			return false;
		}

		if (isset($roomPart[$roomPartName][$columnName])
			&& $roomPart[$roomPartName][$columnName] == 1
		) {
			//権限あり
			return true;
		}

		$partId = $roomPart[$roomPartName]['part_id'];
		$blockPart = $this->AnnouncementBlockPart->findByBlockId($this->blockId, $partId);
		if (isset($blockPart["AnnouncementBlockPart"][$columnName])
			&& $blockPart["AnnouncementBlockPart"][$columnName] == 1
		) {
			return true;
		}
		return false;
	}

/**
 * ブロックに指定されているpartを格納する。
 *
 * @return void
 */
	private function __setBlockPartList() {
		//block idがまだ設定されていないなら空
		//frameIdが無かった場合もありえる。
		if (! $this->blockId) {
			$this->set('blockPart', array());
		}
		//blockPartに設置
		$list = $this->AnnouncementBlockPart->getList($this->blockId);
		$this->set('blockPart', $list);
	}

/**
 * ログインしているユーザのログインIDを取得する。
 *
 * @return mix int or null
 */
	protected function _setLoginUserId() {
		$this->NetCommonsPlugin->getUserId($this);
	}

/**
 * コンテンツの編集権限を確認し、設定する。
 *
 * @param array $roomPart parts_rooms_usersの結果
 * @return bool
 */
	private function __setEdit($roomPart) {
		$columnName = 'edit_content';
		$this->isEdit = $this->__checkPartSetting($roomPart, $columnName);
		$this->set('isEdit', $this->isEdit);
		return $this->isEdit;
	}

/**
 * 言語一覧の設定
 *
 * @param string $lang language
 * @return void
 */
	protected function _setLang($lang = "") {
		//var_dump(Configure::read('Config.language'));
		if (! $lang) {
			$lang = Configure::read('Config.language');
		}
		//$list = Configure::read('Config.languageEnabled');
		$this->langId = 2;
		if ($lang == 'ja') {
			$this->langId = 2;
		} elseif ( $lang == 'en') {
			$this->langId = 1;
		}
		//array_search($lang, $list);
		$this->set('langId', $this->langId);
	}

/**
 * 非同期通信の場合、レイアウトなし設定をする。
 *
 * @return void
 */
	public function setLayout() {
		if ($this->request->is('ajax')) {
			$this->layout = false;
		}
	}

/**
 * contentに対してのパートの取得
 *
 * @return array
 */
	public function setPartList() {
		//room_partの一覧を取得。setし返す。
		$rtn = $this->NetCommonsRoomPart->getList($this->langId);
		$this->set('partList', $rtn);
		//公開権限の可変リスト
		$abilityName = 'publish_content';
		$publishVariableArray = $this->NetCommonsRoomPart->getVariableListPartIds($abilityName);
		$this->set('publishVariableArray', $publishVariableArray);
		//編集権限の可変リスト
		$abilityName = 'publish_content';
		$editVariableArray = $this->NetCommonsRoomPart->getVariableListPartIds($abilityName);
		$this->set('editVariableArray', $editVariableArray);
		return $rtn;
	}
}
