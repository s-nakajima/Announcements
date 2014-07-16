<?php
/**
 * AnnouncementBlockMessage Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementBlockMessage', 'Announcements.Model');

/**
 * Summary for AnnouncementBlockMessage Test Case
 */
class AnnouncementBlockMessageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_block_message'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementBlockMessage = ClassRegistry::init('Announcements.AnnouncementBlockMessage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementBlockMessage);

		parent::tearDown();
	}

	public function testTest() {
		$rtn = true;
		$this->assertTrue($rtn);
	}

/**
 * findByBlockId
 *
 * @return void
 */
	public function testFindByBlockId() {
		//ある場合
		$blockId = 1;
		$langId = 1;
		$rtn = $this->AnnouncementBlockMessage->findByBlockId($blockId, $langId);
		$this->assertTextEquals(1, $rtn["AnnouncementBlockMessage"]['id']);
		//無い場合
		$blockId = 100;
		$rtn = $this->AnnouncementBlockMessage->findByBlockId($blockId, $langId);
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
		$langId = 1;
		$rtn = $this->AnnouncementBlockMessage->getIdByBlockId($blockId, $langId);
		$this->assertTextEquals(1, $rtn);
		//無い場合
		$blockId = 100;
		$rtn = $this->AnnouncementBlockMessage->getIdByBlockId($blockId, $langId);
		$this->assertEquals(null, $rtn);
	}

}
