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
		'plugin.announcements.announcements_block'
	);

/**
 * test data default
 *
 * @var array
 */
	public $testData = array(
		'Announcement' => array(
			array (
				'announcements_block_id' => 1,
				'status' => Announcement::STATUS_PUBLISH,
				'language_id' => 1,
				'is_auto_translation' => null,
				'translation_engine' => null,
				'content' => 'Content Publish',
				'created_user_id' => 1,
			),
			array (
				'announcements_block_id' => 1,
				'status' => Announcement::STATUS_DRAFT,
				'language_id' => 1,
				'is_auto_translation' => null,
				'translation_engine' => null,
				'content' => 'Content Draft',
				'created_user_id' => 1,
			),
		)
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Announcement = ClassRegistry::init('Announcements.Announcement');
		//テスト用データの作成
		$this->Announcement->create();
		$this->assertTrue($this->Announcement->saveAll($this->testData['Announcement']));
		CakeSession::write('Auth.User.id', 1);
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
	public function testGet() {
		//ステータスに関わらず最新を取得
		$blockId = 1;
		$langId = 1;
		$rtn = $this->Announcement->get($blockId, $langId);
		$this->assertTextEquals(
			'Content Draft',
			$rtn['Announcement']['content']
		);
	}

/**
 * testGetPublishData method
 *
 * @return void
 */
	public function testGetPublish() {
		//公開情報を取得
		$blockId = 1;
		$langId = 1;
		$publishOnly = true;
		$rtn = $this->Announcement->get($blockId, $langId, $publishOnly);
		$this->assertTextEquals(
			'Content Publish',
			$rtn['Announcement']['content']
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

		foreach ($statusArray as $key => $num) {
			$data = array(
				$this->Announcement->name => array(
					'content' => rawurlencode('<b>test</b>' . $key),
					'frameId' => 1,
					'blockId' => 1,
					'status' => $key,
					'langId' => 2,
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
	public function testSaveContentError() {
		//frameIdが違う
		$status = 'Publish';
		$data = array(
			$this->Announcement->name => array(
				'content' => rawurlencode('test' . "ほげほげ"),
				'frameId' => 1,
				'blockId' => 1,
				'status' => $status,
				'langId' => 2,
			)
		);
		$frameId = 2;
		$blockId = 1;
		$rtn = $this->Announcement->saveContent($data, $frameId, $blockId);
		$this->assertTextEquals(
			array(),
			$rtn
		);
	}

/**
 * testSaveContent method
 *
 * @return void
 */
	public function testSaveContentErrorSave() {
		//frameIdが違う
		$status = 'Publish';
		$data = array(
			$this->Announcement->name => array(
				'content' => rawurlencode('test' . "ほげほげ"),
				'frameId' => 1,
				'blockId' => 1,
				'status' => $status,
				'langId' => 2,
			)
		);
		$frameId = 2;
		$blockId = 1;
		$rtn = $this->Announcement->saveContent($data, $frameId, $blockId);
		$this->assertTextEquals(
			array(),
			$rtn
		);
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
				'frameId' => 1,
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
				'frameId' => 1,
				'blockId' => 'A', //validation error
				'status' => 'Publish',
				'langId' => 2,
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
