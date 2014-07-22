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
		'Announcements.AnnouncementFrame',
		'Announcements.AnnouncementRoomPart',
		'Announcements.AnnouncementRoom',
		'Announcements.AnnouncementBlockPart',
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
	public $userId = 1;

/**
 * frame 取得とそこからの諸々設定
 *
 * @param int $frameId flames.id
 * @return mixed
 */
	protected function _setFrame($frameId) {
		//frameの情報を取得する
		$frame = $this->AnnouncementFrame->findById($frameId);
		//frameの情報から、諸々設定値を書く王する。
		if ($frame && isset($frame[$this->AnnouncementFrame->name]['id'])) {
			//frames.id
			$this->frameId = $frame[$this->AnnouncementFrame->name]['id'];
			$this->set('frameId', $this->frameId);
			//rooms.id
			$this->roomId = $frame[$this->AnnouncementFrame->name]['room_id'];
			$this->set('roomId', $this->roomId);
			//ブロックID
			$this->blockId = $frame[$this->AnnouncementFrame->name]['block_id'];
			$this->set('blockId', $this->blockId);
			//ルーム管理者の認証が必要かの確認
			$this->isNeedApproval = $this->AnnouncementRoom->checkApproval($this->__roomId);
			$this->set('isNeedApproval', $this->isNeedApproval);
		}
		//block別のpart設定を取得し設定する。
		$this->__setBlockPartList();
		//frameの情報を返す
		return $frame;
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
}
