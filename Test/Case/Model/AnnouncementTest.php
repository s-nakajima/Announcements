<?php
/**
 * Announcement Test
 *
 * @property Announcement $Announcement
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Announcement', 'Announcements.Model');
App::uses('AnnouncementBlock', 'Announcements.Model');

/**
 * Summary for Announcement Test Case
 */
class AnnouncementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.page',
		'plugin.announcements.block',
		'plugin.announcements.part',
		'plugin.announcements.room_part',
		'plugin.announcements.languages_part',
		'plugin.announcements.language',
		'plugin.announcements.announcement',
		'plugin.announcements.announcement_part_setting',
		'plugin.announcements.announcements_block',
		'plugin.announcements.announcement_setting',
		'plugin.announcements.frame',
		'plugin.announcements.parts_rooms_user',
		'plugin.announcements.box',
		'plugin.announcements.plugin',
		'plugin.announcements.room',
		'plugin.announcements.user',
		'plugin.announcements.frames_language',
		'plugin.announcements.blocks_language',
	);

/**
 * 存在するユーザ
 *
 * @var int
 */
	const EXISTING_USER_IN_ROOM = 1;

/**
 * 存在するルーム
 *
 * @var int
 */
	const EXISTING_ROOM = 1;

/**
 * 存在するblockId
 *
 * @var int
 */
	const EXISTING_BLOCK = 1;

/**
 * 存在するannouncements_block_id
 *
 * @var int
 */
	const EXISTING_ANNOUNCEMENT_BLOCK_ID = 1;

/**
 * 存在するlanguages.id
 *
 * @var int
 */
	const EXISTING_LANG_ID = 1;


/**
 * 存在するframe
 *
 * @var int
 */
	const EXISTING_FRAME = 1;

/**
 * 存在しないユーザ
 *
 * @var int
 */
	const NOT_EXISTING_USER = 10000;

/**
 * 存在しないルーム
 *
 * @var int
 */
	const NOT_EXISTING_ROOM = 10000;


/**
 * 存在しないBLOCK
 *
 * @var int
 */
	const NOT_EXISTING_BLOCK = 10000;

/**
 * 存在しないannouncements_block_id
 *
 * @var int
 */
	const NOT_EXISTING_ANNOUNCEMENT_BLOCK_ID = 10000;


/**
 * Announcements status publish
 *
 * @var int
 */
	const STATUS_PUBLISH = 1;

/**
 * Announcements status publish
 *
 * @var int
 */
	const STATUS_PUBLISH_REQUEST = 2;

/**
 * Announcements status Draft
 *
 * @var int
 */
	const STATUS_DRAFT = 3;

/**
 * Announcements status Reject
 *
 * @var int
 */
	const STATUS_REJECT = 4;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Announcement = ClassRegistry::init('Announcements.Announcement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Announcement);
		parent::tearDown();
	}

/**
 * testGet method
 *
 * @return void
 */
	public function testGetContent() {
		$rtn = $this->Announcement->getContent(self::EXISTING_BLOCK, self::EXISTING_LANG_ID, 1);
		$this->assertTextEquals(
			'Content Draft',
			$rtn[$this->Announcement->name]['content']
		);
	}

/**
 * testGetPublishData method
 *
 * @return void
 */
	public function testGetPublish() {
		//公開情報を取得
		$rtn = $this->Announcement->getContent(self::EXISTING_BLOCK, self::EXISTING_LANG_ID);
		$this->assertTextEquals(
			'Content Publish',
			$rtn[$this->Announcement->name]['content']
		);
	}

/**
 * testSaveContent method
 *
 * @return void
 */
	public function testSaveContent() {
		//ステータスごとのお知らせ保存
		$statusArray = array(
			'Publish',
			'PublishRequest',
			'Draft',
			'Reject'
		);

		CakeSession::write('Auth.User.id', self::EXISTING_USER_IN_ROOM);

		foreach ($statusArray as $key) {
			$data = array(
				$this->Announcement->name => array(
					'content' => rawurlencode('<b>test</b>' . $key),
					'frameId' => 1,
					'blockId' => 1,
					'status' => $key,
					'langId' => self::EXISTING_LANG_ID,
				)
			);
			$frameId = 1;
			$blockId = 1;
			$rtn = $this->Announcement->saveContent($data, $frameId, $blockId);
			$this->assertTextEquals(
				rawurldecode($data[$this->Announcement->name]['content']),
				$rtn[$this->Announcement->name]['content']
			);
		}
	}

/**
 * testSaveContent method
 *
 * @return void
 */
	public function testSaveContentErrorSave() {
		$data = array(
			$this->Announcement->name => array(
				'content' => rawurlencode('test'),
				'frameId' => self::EXISTING_FRAME,
				'blockId' => self::EXISTING_BLOCK,
				'status' => 'Publish',
				'langId' => self::EXISTING_LANG_ID,
			)
		);
		//For frameId and argument frameId in the array is different, do not save
		$frameId = self::EXISTING_FRAME + 1;
		$rtn = $this->Announcement->saveContent($data, $frameId, self::EXISTING_BLOCK);
		$this->assertTextEquals(array(), $rtn);
	}

/**
 * test saveContent method
 *
 * @return void
 */
	public function estSaveContentCreateAnnouncementsBlock() {
		//announcements_blocks.id does not exist
		$status = 'Publish';
		$data = array(
			$this->Announcement->name => array(
				'content' => 'test',
				'frameId' => self::EXISTING_FRAME,
				'blockId' => 5,
				'status' => $status,
				'langId' => 2,
			)
		);
		$frameId = 1;
		$blockId = 6;
		$rtn = $this->Announcement->saveContent($data, $frameId, $blockId, false);
		$this->assertTextEquals(
			Announcement::STATUS_PUBLISH,
			$rtn[$this->Announcement->name]['status']
		);
	}

/**
 * test saveContent method
 *
 * @return void
 */
	public function estSaveContentCreateAnnouncementsBlockError() {
		//announcements_blocks.id error
		$data = array(
			$this->Announcement->name => array(
				'content' => 'test' . "Error",
				'frameId' => self::EXISTING_FRAME,
				'blockId' => 'A', //validation error
				'status' => 'Publish',
				'langId' => self::EXISTING_LANG_ID,
			)
		);
		$frameId = 1;
		$blockId = 10;
		$rtn = $this->Announcement->saveContent($data, $frameId, $blockId, false);
		$this->assertTextEquals(
			$data[$this->Announcement->name]['content'],
			$rtn[$this->Announcement->name]['content']
		);
	}

/**
 * test saveContent method validation error
 *
 * @return void
 */
	public function testSaveContentErrorValidationLangId() {
		$data = array(
			$this->Announcement->name => array(
				'content' => 'test' . "ほげほげ",
				'frameId' => 1,
				'blockId' => 1, //validation error
				'status' => 'Publish',
				'langId' => "ja", //Announcement validation error
			)
		);
		$frameId = 1;
		$blockId = 1;
		$rtn = $this->Announcement->saveContent($data, $frameId, $blockId, false);
		$this->assertTextEquals(
			array(),
			$rtn
		);
	}

}
