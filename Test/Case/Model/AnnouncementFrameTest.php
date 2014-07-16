<?php
/**
 * Announcement Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementFrame', 'Announcements.Model');


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
		'plugin.announcements.announcement_frame'
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
}
