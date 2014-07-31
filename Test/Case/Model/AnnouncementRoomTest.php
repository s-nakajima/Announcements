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
class AnnouncementRoomTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_room'
	);

	public $Room;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Room = ClassRegistry::init('Announcements.AnnouncementRoom');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Room);
		parent::tearDown();
	}

/**
 * testCheckApprovalTrue
 *
 * @return void
 */
	public function testCheckApprovalTrue() {
		$roomId = 1;
		$rtn = $this->Room->checkApproval($roomId);
		$this->assertTrue($rtn);
	}

/**
 * testCheckApprovalFalse
 *
 * @return void
 */
	public function testCheckApprovalFalse() {
		$roomId = 2;
		$rtn = $this->Room->checkApproval($roomId);
		$this->assertFalse($rtn);
	}
}
