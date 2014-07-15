<?php
/**
 * AnnouncementsBlockSetting Controller
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
App::uses(
	'AnnouncementsAppController',
	'Announcements.Controller'
);

class AnnouncementsBlockSettingController extends AnnouncementsAppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
		'Announcements.AnnouncementBlock',
		'Announcements.AnnouncementDatum',
		'Announcements.AnnouncementsFrame', //frames
		'Announcements.AnnouncementRoomPart',
	);

/**
 * 言語ID
 *
 * @var int
 */
	public $langId = 2;

/**
 * 準備
 *
 * @return void
 */
	public function beforeFilter() {
		//親処理
		parent::beforeFilter();
	}

/**
 * index
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function index($frameId) {
		$this->layout = false;
		$this->set('frameId', $frameId);
		$this->set('partList', $this->__getPartList());
	}

/**
 * パートの取得
 *
 * @return array
 * @SuppressWarnings(PHPMD)
 */
	private function __getPartList() {
		return $this->AnnouncementRoomPart->getList($this->langId);
	}
}