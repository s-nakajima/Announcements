<?php
/**
 * AnnouncementsAppController
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AppController', 'Controller');

class AnnouncementsAppController extends AppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
		'Announcements.AnnouncementBlock',
		'Announcements.AnnouncementDatum',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomPart',
		'NetCommons.NetCommonsRoom',
		'Announcements.AnnouncementBlockPart',
		'Announcements.AnnouncementPartsRoomsUser',
	);

/**
 * ccomponents
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
		'Security'
	);

/**
 * ルーム管理者の承認が必要
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
 * users.id
 *
 * @var int
 */
	public $userId = 0;

/**
 * ルーム管理者のpart_id
 *
 * @var int
 */
	protected $_RoomAdminPartId = 1;

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
 * frame 取得とそこからの諸々設定
 *
 * @param int $frameId flames.id
 * @return mixed
 */
	protected function _setFrame($frameId) {
		//frameの情報を取得する
		$frame = $this->NetCommonsFrame->findById($frameId);
		//frameの情報から、諸々設定値を書く王する。
		if ($frame && isset($frame[$this->NetCommonsFrame->name]['id'])) {
			//frames.id
			$this->frameId = $frame[$this->NetCommonsFrame->name]['id'];
			$this->set('frameId', $this->frameId);
			//rooms.id
			$this->roomId = $frame[$this->NetCommonsFrame->name]['room_id'];
			$this->set('roomId', $this->roomId);
			//ブロックID
			$this->blockId = $frame[$this->NetCommonsFrame->name]['block_id'];
			$this->set('blockId', $this->blockId);
			//ルーム管理者の認証が必要かの確認
			$this->isNeedApproval = $this->NetCommonsRoom->checkApproval($this->__roomId);
			$this->set('isNeedApproval', $this->isNeedApproval);

			//edit_contentの権限を確認する
			$roomPart = $this->__getRoomPart();
			$this->__setEdit($roomPart);
			//ルーム管理者かどうか確認する。
			$this->__setRoomAdmin($roomPart);
			//コンテンツの公開権限を確認し、設定する。
			$this->__setPublishContent($roomPart, $this->isNeedApproval);
			//ブロックの編集権限を確認し設定する。
			$this->__setEditBLock($roomPart);
		}
		//block別のpart設定を取得し設定する。
		$this->__setBlockPartList();
		//frameの情報を返す
		return $frame;
	}

/**
 * コンテンツの公開権限を確認し格納する。
 *
 * @param array $roomPart ルーム内でログインユーザの担当しているパートの情報
 * @param bool $isNeedApproval ルーム管理者の承認が必要かどうか
 * @return bool
 */
	private function __setPublishContent($roomPart, $isNeedApproval) {
		$this->set('isPublish', false); //初期値
		$columnName = 'publish_content';
		$blockId = $this->blockId;
		$rtn = $this->__checkPartSetting($roomPart, $columnName, $blockId);
		if ($isNeedApproval && $this->isRoomAdmin) {
			//ルーム管理者の承認がひつようで、ルーム管理者
			$this->isPublish = $rtn;
			$this->set('isPublish', $this->isPublish);
			return $this->isPublish;
		} elseif ($isNeedApproval && ! $this->isRoomAdmin) {
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
 * ブロックの編集権限を確認し設定する。
 *
 * @param array $roomPart room_parts parts_rooms_usersのselect結果
 * @return bool
 */
	private function __setEditBLock($roomPart) {
		$columnName = 'edit_block';
		$blockId = $this->blockId;
		$this->isBlockEdit = $this->__checkPartSetting($roomPart, $columnName, $blockId);
		$this->set('isBlockEdit', $this->isBlockEdit);
		return $this->isBlockEdit;
	}

/**
 * 権限チェック あとでモデルに移す。
 *
 * @param array $roomPart room part
 * @param string $columnName チェックしたいカラム
 * @param int $blockId blocks.id
 * @return bool
 * @SuppressWarnings(PHPMD)
 */
	private function __checkPartSetting($roomPart, $columnName, $blockId) {
		$RoomsUserName = $this->AnnouncementPartsRoomsUser->name;
		if (! $roomPart
			|| ! isset($roomPart['RoomPart'])
			|| ! isset($roomPart[$RoomsUserName])
			|| ! isset($roomPart[$RoomsUserName]['part_id'])
		) {
			return false;
		}
		//roomPartから、$columnNameの値が1か0をみて、0だったらfalse 1だったらtrueを返す
		//2だった場合は可変なので、partIdとroomIdからレコードを取り出し、設定を見る。1ならtrue 0ならfalse
		if (isset($roomPart['RoomPart'][$columnName])
			&& $roomPart['RoomPart'][$columnName] == 0
		) {
			//権限無し
			return false;
		}
		if (isset($roomPart['RoomPart'][$columnName])
			&& $roomPart['RoomPart'][$columnName] == 1
		) {
			//権限あり
			return true;
		}
		//blockがまだ作られていない場合
		if (! $blockId) {
			return false;
		}
		$partId = $roomPart[$RoomsUserName]['part_id'];
		$blockPart = $this->AnnouncementBlockPart->findByBlockId($blockId, $partId);
		if (isset($blockPart[$RoomsUserName][$columnName])
			&& $blockPart[$RoomsUserName][$columnName] == 1
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
		if ($this->Auth->loggedIn()) {
			$this->userId = AuthComponent::user('id');
			$this->Set('isLogin', true);
			return $this->userId;
		}
		$this->Set('isLogin', false);
	}

/**
 * ルーム管理者か判定して設定する。
 *
 * @param array $roomPart parts_rooms_usersの結果
 * @return bool
 */
	private function __setRoomAdmin($roomPart) {
		//初期値
		$this->isRoomAdmin = false;
		$this->set('isRoomAdmin', $this->isRoomAdmin);
		if (isset($roomPart['RoomPart'])
			&& $roomPart['RoomPart']['part_id'] == $this->_RoomAdminPartId
		) {
			//権限無し
			$this->isRoomAdmin = true;
			$this->set('isRoomAdmin', $this->isRoomAdmin);
			return true;
		}
		return false;
	}

/**
 * ログインしているユーザのPartを取得する
 *
 * @return mixed
 */
	private function __getRoomPart() {
		//共通処理にすべき : Modelに移動したい
		return $this->AnnouncementPartsRoomsUser->getRoomPart($this->roomId, $this->userId);
	}

/**
 * コンテンツの編集権限を確認し、設定する。
 *
 * @param array $roomPart parts_rooms_usersの結果
 * @return bool
 */
	private function __setEdit($roomPart) {
		$columnName = 'edit_content';
		$blockId = $this->blockId;
		$this->isEdit = $this->__checkPartSetting($roomPart, $columnName, $blockId);
		$this->set('isEdit', $this->isEdit);
		return $this->isEdit;
	}

/**
 * 言語一覧の設定
 *
 * @return void
 */
	protected function _setLang() {
		//var_dump(Configure::read('Config.language'));
		$lang = Configure::read('Config.language');
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
}
