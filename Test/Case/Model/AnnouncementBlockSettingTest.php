<?php
/**
 * AnnouncementBlockSetting Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementBlockSetting', 'Announcements.Model');

/**
 * Summary for AnnouncementBlockSetting Test Case
 */
class AnnouncementBlockSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_block_setting'
	);

/**
 * class object
 *
 * @var object
 */
	public $BlockSetting;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlockSetting = ClassRegistry::init('Announcements.AnnouncementBlockSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlockSetting );
		parent::tearDown();
	}

/**
 * findByBlockId
 *
 * @return void
 */
	public function testFindByBlockId() {
		//ある場合
		$blockId = 1;
		$rtn = $this->BlockSetting->findByBlockId($blockId);
		$this->assertTextEquals(1, $rtn["AnnouncementBlockSetting"]['id']);
		//無い場合
		$blockId = 100;
		$rtn = $this->BlockSetting->findByBlockId($blockId);
		$this->assertEquals(array(), $rtn);
	}

/**
 * getIdByBlockId
 *
 * @return void
 */
	public function testGetIdByBlockId() {
		//ある場合
		$blockId = 1;
		$rtn = $this->BlockSetting->getIdByBlockId($blockId);
		$this->assertTextEquals(1, $rtn);
		//無い場合
		$blockId = 100;
		$rtn = $this->BlockSetting->getIdByBlockId($blockId);
		$this->assertEquals(null, $rtn);
	}
}
