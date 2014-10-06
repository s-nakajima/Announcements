<?php
/**
 * AnnouncementSetting Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementSetting', 'Announcements.Model');

/**
 * Summary for AnnouncementSetting Test Case
 */
class AnnouncementSettingTest extends CakeTestCase {

/**
 * Existing users.id
 *
 * @var int
 */
	const EXISTING_USER_IN_ROOM = 1;

/**
 * Existing rooms.id
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
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_setting',
		'plugin.announcements.announcement_part_setting',
		'plugin.announcements.block',
		'plugin.announcements.language',
		'plugin.announcements.blocks_language',
		'plugin.announcements.part',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementPartSetting = ClassRegistry::init('Announcements.AnnouncementPartSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementPartSetting);

		parent::tearDown();
		CakeSession::delete('Auth.User.id');
	}

/**
 * test find
 *
 * @return void
 */
	public function testFind() {
		$rtn = $this->AnnouncementPartSetting->find('first');
		$this->assertTrue(is_array($rtn));
	}
}
