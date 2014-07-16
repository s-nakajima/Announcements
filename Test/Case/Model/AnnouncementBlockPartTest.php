<?php
/**
 * AnnouncementBlockPart Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementBlockPart', 'Announcements.Model');

/**
 * Summary for AnnouncementBlockPart Test Case
 */
class AnnouncementBlockPartTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_block_part'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementBlockPart = ClassRegistry::init('Announcements.AnnouncementBlockPart');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementBlockPart);

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
		$partId = 1;
		$rtn = $this->AnnouncementBlockPart->findByBlockId($blockId, $partId);
		$this->assertTextEquals(1, $rtn["AnnouncementBlockPart"]['id']);
		//無い場合
		$blockId = 100;
		$rtn = $this->AnnouncementBlockPart->findByBlockId($blockId, $partId);
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
		$partId = 1;
		$rtn = $this->AnnouncementBlockPart->getIdByBlockId($blockId, $partId);
		$this->assertTextEquals(1, $rtn);
		//無い場合
		$blockId = 100;
		$rtn = $this->AnnouncementBlockPart->getIdByBlockId($blockId, $partId);
		$this->assertEquals(null, $rtn);
	}

/**
 * getList
 *
 * @return void
 */
	public function testGetList() {
		$blockId = 1;
		$rtn = $this->AnnouncementBlockPart->getList($blockId);
		$this->assertEquals(1, count($rtn));
	}
}
