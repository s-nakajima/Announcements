<?php
/**
 * Announcement Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementFrame', 'Announcements.Model');
App::uses('AnnouncementBlock', 'Announcements.Model');


/**
 * Summary for Announcement Test Case
 */
class AnnouncementFrameTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_frame',
		'plugin.announcements.announcement_block_block'
	);

	public $AnnouncementsFrame;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementsFrame = ClassRegistry::init('Announcements.AnnouncementFrame');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementsFrame);
		parent::tearDown();
	}

/**
 * testGetBlockId
 *
 * @return void
 */
	public function testGetBlockId() {
		$frameId = 1;
		$rtn = $this->AnnouncementsFrame->getBlockId($frameId);
		$this->assertTextEquals($rtn, 1);
	}

/**
 * testGetBlockIdNoData
 *
 * @return void
 */
	public function testGetBlockIdNoData() {
		$frameId = 9999999999;
		$rtn = $this->AnnouncementsFrame->getBlockId($frameId);
		$this->assertNull($rtn);
	}

/**
 * createBlock
 *
 * @return void
 */
	public function testCreateBlock() {
		$frameId = 1;
		$userId = 1;
		$rtn = $this->AnnouncementsFrame->createBlock($frameId, $userId);
		$this->assertTextEquals($userId, $rtn['AnnouncementBlock']['created_user_id']);
	}

/**
 * createBlock frames.id error
 *
 * @return void
 */
	public function testCreateBlockNoFrame() {
		$frameId = 9999999999;
		$userId = 1;
		$rtn = $this->AnnouncementsFrame->createBlock($frameId, $userId);
		$this->assertTextEquals(null, $rtn);
	}

/**
 * updateBlockId
 *
 * @return void
 */
	public function testUpdateBlockId() {
		$flameId = 1;
		$userId = 1;
		$blockId = 1;
		$rtn = $this->AnnouncementsFrame->updateBlockId($flameId, $blockId, $userId);
		$this->assertTrue(is_array($rtn));
	}

}
