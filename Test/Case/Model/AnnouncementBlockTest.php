<?php
/**
 * AnnouncementBlock Test Case
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementBlock', 'Announcements.Model');

/**
 * Summary for AnnouncementBlock Test Case
 */
class AnnouncementBlockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_block',
		'plugin.announcements.announcement_blocks_part',
		'plugin.announcements.room_part',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementBlock = ClassRegistry::init('Announcements.AnnouncementBlock');
		$this->AnnouncementBlocksPart = ClassRegistry::init('Announcements.AnnouncementBlocksPart');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementBlock);
		unset($this->AnnouncementBlocksPart);

		parent::tearDown();
	}

/**
 * testFindByBlockIdOrDefault method
 *
 * @return void
 */
	public function testFindByBlockIdOrDefault() {
		// 該当データあり
		$blockId = 1;
		$result = $this->AnnouncementBlock->findByBlockIdOrDefault($blockId);
		$this->assertEquals($result[$this->AnnouncementBlock->alias]['send_mail'], 1);
		$this->assertEquals(count($result[$this->AnnouncementBlocksPart->alias]), 5);

		$blockPart = $result[$this->AnnouncementBlocksPart->alias][0];
		$this->assertEquals($blockPart['part_id'], 1);
		$this->assertEquals($blockPart['announcement_block_id'], 10);
		$this->assertTrue($blockPart['can_edit_content']);
		$this->assertTrue($blockPart['can_publish_content']);

		// 該当データなし
		$result = $this->AnnouncementBlock->findByBlockIdOrDefault(0);
		$this->assertEquals($result[$this->AnnouncementBlock->alias]['send_mail'], 0);
		$this->assertEquals(count($result[$this->AnnouncementBlocksPart->alias]), 5);

		$blockPart = $result[$this->AnnouncementBlocksPart->alias][0];
		$this->assertEquals($blockPart['part_id'], 1);
		$this->assertEquals($blockPart['announcement_block_id'], 0);
		$this->assertTrue($blockPart['can_edit_content']);
		$this->assertTrue($blockPart['can_publish_content']);
	}

/**
 * testFindByBlockIdOrDefault method
 *
 * @return void
 */
	public function testFindByAuthOrDefault() {
		$partId = 1;
		// 該当データあり
		$blockId = 1;
		$result = $this->AnnouncementBlock->findByAuthOrDefault($blockId, $partId);
		$this->assertEquals($result[$this->AnnouncementBlock->alias]['send_mail'], 1);
		$this->assertTrue($result[$this->AnnouncementBlocksPart->alias]['can_edit_content']);
		$this->assertTrue($result[$this->AnnouncementBlocksPart->alias]['can_publish_content']);
		$this->assertFalse($result[$this->AnnouncementBlocksPart->alias]['can_send_mail']);

		// 該当データなし
		$result = $this->AnnouncementBlock->findByAuthOrDefault(0, $partId);
		$this->assertEquals($result[$this->AnnouncementBlock->alias]['send_mail'], 0);
		$this->assertTrue($result[$this->AnnouncementBlocksPart->alias]['can_edit_content']);
		$this->assertTrue($result[$this->AnnouncementBlocksPart->alias]['can_publish_content']);
		$this->assertTrue($result[$this->AnnouncementBlocksPart->alias]['can_send_mail']);
	}

}
