<?php
/**
 * AnnouncementNotification Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementNotification', 'Announcements.Model');

/**
 * Summary for AnnouncementNotification Test Case
 */
class AnnouncementNotificationTest extends CakeTestCase {

/**
 *  Existing users.id
 *
 *  @var int
 */
	const EXISTING_USER_IN_ROOM = 1;

/**
 *  Existing rooms.id
 *
 *  @var int
 */
	const EXISTING_ROOM = 1;

/**
 *  Not Existing users.id
 *
 *  @var int
 */
	const NOT_EXISTING_USER = 10000;

/**
 *  Not Existing rooms.id
 *
 *  @var int
 */
	const NOT_EXISTING_ROOM = 10000;

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_notification',
		'plugin.announcements.block',
		'plugin.announcements.language',
		'plugin.announcements.blocks_language'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementNotification = ClassRegistry::init('Announcements.AnnouncementNotification');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementNotification);

		parent::tearDown();
	}

/**
 * test find
 *
 * @return void
 */
	public function testFind() {
		$rtn = $this->AnnouncementNotification->find('first');
		$this->assertTrue(is_array($rtn));
	}
}

