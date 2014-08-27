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
 * 存在するユーザ
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
	public function testMyid() {
		$frameId = 1;
		$blockId = 1;
		$id = 1;
		$rtn = $this->AnnouncementsBlock->myId($frameId, $blockId);
		$this->assertTrue(is_numeric($rtn));
		$this->assertEquals($rtn, $id);

		$frameId = 5;
		$blockId = 0;
		$rtn = $this->AnnouncementsBlock->myId($frameId, $blockId);
		$this->assertNull($rtn);

		CakeSession::write('Auth.User.id', self::EXISTING_USER);
		$frameId = 5;
		$blockId = 0;
		$rtn = $this->AnnouncementsBlock->myId($frameId, $blockId);
		$this->assertTrue(is_numeric($rtn));
	}

}