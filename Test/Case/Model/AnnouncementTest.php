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
		'plugin.announcements.announcement',
		'plugin.announcements.announcements_block',
		'plugin.announcements.language',
		'plugin.announcements.block',
		'plugin.announcements.Part',
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
	public function estGet() {
		//ステータスに関わらず最新を取得 存在する。
		$rtn = $this->Announcement->get(self::EXISTING_BLOCK, self::EXISTING_LANG_ID);
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
		$rtn = $this->Announcement->get(self::EXISTING_BLOCK, self::EXISTING_LANG_ID, true);
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
			'Publish' => Announcement::STATUS_PUBLISH,
			'PublishRequest' => Announcement::STATUS_PUBLISH_REQUEST,
			'Draft' => Announcement::STATUS_DRAFT,
			'Reject' => Announcement::STATUS_REJECT
		);

		CakeSession::write('Auth.User.id', self::EXISTING_USER_IN_ROOM);

		foreach ($statusArray as $key => $num) {
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
				$num,
				$rtn[$this->Announcement->name]['status']
			);
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
				'content' => rawurlencode('test' . "ほげほげ"),
				'frameId' => self::EXISTING_FRAME,
				'blockId' => self::EXISTING_BLOCK,
				'status' => 'Publish',
				'langId' => self::EXISTING_LANG_ID,
			)
		);
		//配列の中のframeIdと引数のframeIdが違うため、保存させない
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
		//announcements_blocks.idが無い場合
		$status = 'Publish';
		$data = array(
			$this->Announcement->name => array(
				'content' => 'test' . "ほげほげ",
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
	public function testSaveContentCreateAnnouncementsBlockError() {
		//announcements_blocks.idが無い場合
		$data = array(
			$this->Announcement->name => array(
				'content' => 'test' . "ほげほげ",
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
