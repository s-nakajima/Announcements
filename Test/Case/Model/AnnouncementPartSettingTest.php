<?php
/**
 * AnnouncementPartSetting Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementPartSetting', 'Announcements.Model');

/**
 * Summary for AnnouncementPartSetting Test Case
 */
class AnnouncementPartSettingTest extends CakeTestCase {

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
 * Existing part.id
 *
 * @var int
 */
	const EXISTING_PART = 1;

/**
 * Existing language.id
 *
 * @var int
 */
	const EXISTING_LANG_ID = 1;

/**
 * Existing announcements_block_id
 *
 * @var int
 */
	const EXISTING_ANNOUNCEMENT_BLOCK_ID = 1;

/**
 *  Not existed  users.id
 *
 * @var int
 */
	const NOT_EXISTING_USER = 10000;

/**
 * Not existed rooms.id
 *
 * @var int
 */
	const NOT_EXISTING_ROOM = 10000;

/**
 * Not existed parts.id
 *
 * @var int
 */
	const NOT_EXISTING_PART = 10000;

/**
 * Not existed blocks.id
 *
 * @var int
 */
	const NOT_EXISTING_BLOCK = 10000;

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
 * testGetList method
 *
 * @return void
 */
	public function testGetList() {
		$rtn = $this->AnnouncementPartSetting->getList(self::EXISTING_BLOCK);
		$this->assertTrue(is_array($rtn));
		$this->assertEquals(
			self::EXISTING_BLOCK,
			$rtn[0][$this->AnnouncementPartSetting->name]['block_id']
		);
	}

/**
 * getListPartIdArray
 *
 * @return void
 */
	public function testGetListPartIdArray() {
		$rtn = $this->AnnouncementPartSetting->getListPartIdArray(self::EXISTING_BLOCK);
		$this->assertTrue(is_array($rtn));
		$this->assertEquals(
			$rtn[self::EXISTING_BLOCK]['part_id'],
			self::EXISTING_PART
		);
		//Block that do not exist.
		$rtn = $this->AnnouncementPartSetting->getListPartIdArray(self::NOT_EXISTING_BLOCK);
		$this->assertTrue(is_array($rtn));
		$this->assertEquals($rtn, array());
	}

/**
 * getIdByBlockId
 *
 * @return void
 */
	public function testGetIdByBlockId() {
		//Block that do not exist. Part that do not exist.
		$rtn = $this->AnnouncementPartSetting->getIdByBlockId(self::NOT_EXISTING_BLOCK, self::NOT_EXISTING_PART);
		$this->assertEquals(null, $rtn);

		//Block and Part that do not exist.
		$rtn = $this->AnnouncementPartSetting->getIdByBlockId(self::EXISTING_BLOCK, self::EXISTING_PART);
		$this->assertTrue(is_numeric($rtn));
		$this->assertNotEmpty($rtn);

		//Block that do not exist. Part that exist.
		$rtn = $this->AnnouncementPartSetting->getIdByBlockId(self::NOT_EXISTING_BLOCK, self::EXISTING_PART);
		$this->assertEquals(null, $rtn);

		//Block that exist. Part do not exist.
		$rtn = $this->AnnouncementPartSetting->getIdByBlockId(self::EXISTING_BLOCK, self::NOT_EXISTING_PART);
		$this->assertEquals(null, $rtn);
	}

}
