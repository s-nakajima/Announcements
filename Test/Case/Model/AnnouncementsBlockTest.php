<?php
/**
 * AnnouncementsBlock Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsBlock', 'Announcements.Model');

/**
 * Summary for AnnouncementsBlock Test Case
 */
class AnnouncementsBlockTest extends CakeTestCase {

/**
 * Existing users.id
 *
 * @var int
 */
	const EXISTING_USER = 1;

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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementsBlock = ClassRegistry::init('Announcements.AnnouncementsBlock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementsBlock);

		parent::tearDown();
	}

/**
 * find findbyid
 *
 * @return void
 */
	public function testGetAnnouncementsBlockId() {
		CakeSession::write('Auth.User.id', self::EXISTING_USER);
		$frameId = 1;
		$blockId = 1;
		$announcementsBlockId = 1;
		$rtn = $this->AnnouncementsBlock->getAnnouncementsBlockId($frameId, $blockId);
		$this->assertTrue(is_numeric($rtn));
		$this->assertEquals($rtn, $announcementsBlockId);

		$frameId = 5;
		$blockId = 0;
		$rtn = $this->AnnouncementsBlock->getAnnouncementsBlockId($frameId, $blockId);
		$this->assertTrue(is_numeric($rtn));
	}

	public function testCreateByBlock() {
		CakeSession::write('Auth.User.id', self::EXISTING_USER);
		$blockId = 5;
		$rtn = $rtn = $this->AnnouncementsBlock->createByBlock($blockId);
		$this->assertTrue(is_numeric($rtn));

		$blockId = 'A'; //validation error
		$rtn = $rtn = $this->AnnouncementsBlock->createByBlock($blockId);
		$this->assertNull($rtn);
	}

}
