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
 * Existing users.id
 *
 * @var int
 */
	const EXISTING_USER_IN_ROOM = 1;

/**
 * Existing .rooms.id
 *
 * @var int
 */
	const EXISTING_ROOM = 1;

/**
 * Existing blocks.id
 *
 * @var int
 */
	const EXISTING_BLOCK = 1;

/**
 * Existing announcements_block_id
 *
 * @var int
 */
	const EXISTING_ANNOUNCEMENT_BLOCK_ID = 1;

/**
 * Existing languages.id
 *
 * @var int
 */
	const EXISTING_LANG_ID = 1;


/**
 * Existing frame.id
 *
 * @var int
 */
	const EXISTING_FRAME = 1;

/**
 * Not existing users.id
 *
 * @var int
 */
	const NOT_EXISTING_USER = 10000;

/**
 * Not existing rooms.id
 *
 * @var int
 */
	const NOT_EXISTING_ROOM = 10000;


/**
 * Not existing blocks.id
 *
 * @var int
 */
	const NOT_EXISTING_BLOCK = 10000;

/**
 * Not existing announcements_block_id
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
	public function testGetLatestContent() {
		$rtn = $this->Announcement->getLatestContent(self::EXISTING_BLOCK, self::EXISTING_LANG_ID);
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
		$rtn = $this->Announcement->getPublishContent(self::EXISTING_BLOCK, self::EXISTING_LANG_ID);
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
		//contents status list
		$contentStatusArray = array(
			'Publish',
			'PublishRequest',
			'Draft',
			'Reject'
		);

		CakeSession::write('Auth.User.id', self::EXISTING_USER_IN_ROOM);

		foreach ($contentStatusArray as $contentStatus) {
			$data = array(
				$this->Announcement->name => array(
					'content' => rawurlencode('<b>test</b>' . $contentStatus),
					'frameId' => self::EXISTING_FRAME,
					'blockId' => self::EXISTING_BLOCK,
					'status' => $contentStatus,
					'langId' => self::EXISTING_LANG_ID,
				)
			);

			$rtn = $this->Announcement->saveContent($data, self::EXISTING_FRAME, self::EXISTING_BLOCK);
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
	public function testSaveContentCreateAnnouncementsBlock() {
		//announcements_blocks.id does not exist
		$status = 'Publish';
		$data = array(
			$this->Announcement->name => array(
				'content' => 'test',
				'frameId' => self::EXISTING_FRAME,
				'blockId' => self::NOT_EXISTING_BLOCK,
				'status' => $status,
				'langId' => 2,
			)
		);
		$rtn = $this->Announcement->saveContent($data, self::EXISTING_FRAME, self::NOT_EXISTING_BLOCK, false);
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
	public function testSaveContentCreateAnnouncementsBlockError() {
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
		$rtn = $this->Announcement->saveContent($data, self::EXISTING_FRAME, self::EXISTING_BLOCK, false);
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
				'content' => 'test',
				'frameId' => self::EXISTING_FRAME,
				'blockId' => self::EXISTING_BLOCK,
				'status' => 'Publish',
				'langId' => "ja", //Announcement validation error
			)
		);
		$rtn = $this->Announcement->saveContent($data, self::EXISTING_FRAME, self::EXISTING_BLOCK, false);
		$this->assertTextEquals(
			array(),
			$rtn
		);
	}

}
