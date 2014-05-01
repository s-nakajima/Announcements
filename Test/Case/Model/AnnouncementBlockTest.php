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
		'plugin.announcements.announcement_blocks_part'
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
 * testGetInitializeData method
 *
 * @return void
 */
	public function testGetInitializeData() {
		// 該当データあり
		$blockId = 1;
		$result = $this->AnnouncementBlock->findByBlockIdOrDefault($blockId);
		$this->assertEquals($result[$this->AnnouncementBlock->alias]['send_mail'], 1);
		$this->assertEquals(count($result[$this->AnnouncementBlocksPart->alias]), 4);

		$blockPart = $result[$this->AnnouncementBlocksPart->alias][0];
		$this->assertEquals($blockPart['part_id'], 1);
		$this->assertEquals($blockPart['announcement_block_id'], 10);
		$this->assertEquals($blockPart['can_create_content'], 1);
		$this->assertEquals($blockPart['can_publish_content'], 1);

		// 該当データなし
		$blockId = 2;
		$result = $this->AnnouncementBlock->findByBlockIdOrDefault($blockId);
		$this->assertEquals($result[$this->AnnouncementBlock->alias]['send_mail'], 0);
		$this->assertEquals(count($result[$this->AnnouncementBlocksPart->alias]), 4);

		$blockPart = $result[$this->AnnouncementBlocksPart->alias][0];
		$this->assertEquals($blockPart['part_id'], 1);
		$this->assertEquals($blockPart['announcement_block_id'], 0);
		$this->assertEquals($blockPart['can_create_content'], 1);
		$this->assertEquals($blockPart['can_publish_content'], 1);
	}

}
