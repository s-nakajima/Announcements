<?php
/**
 * AnnouncementBlocksPart Test Case
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementBlocksPart', 'Announcements.Model');

/**
 * Summary for AnnouncementBlocksPart Test Case
 */
class AnnouncementBlocksPartTest extends CakeTestCase {

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
		$announcementBlock = $this->AnnouncementBlock->findByBlockId($blockId);

		$ret = $this->AnnouncementBlocksPart->findByAnnouncementBlockIdOrDefault($announcementBlock['AnnouncementBlock']['id']);
		$this->assertEquals(count($ret[$this->AnnouncementBlocksPart->alias]), 5);

		// 該当データなし
		$ret = $this->AnnouncementBlocksPart->findByAnnouncementBlockIdOrDefault(0);
		$this->assertEquals(count($ret[$this->AnnouncementBlocksPart->alias]), 5);

		$blockPart = $ret[$this->AnnouncementBlocksPart->alias][0];
		$this->assertEquals($blockPart['part_id'], 1);
		$this->assertEquals($blockPart['announcement_block_id'], 0);
		$this->assertEquals($blockPart['can_edit_content'], 1);
		$this->assertEquals($blockPart['can_publish_content'], 1);
		$this->assertEquals($blockPart['can_send_mail'], 1);
	}

/**
 * testFindByKeysOrDefault method
 *
 * @return void
 */
	public function testFindByKeysOrDefault() {
		// 該当データあり
		$blockId = 1;
		$partId = 1;
		$announcementBlock = $this->AnnouncementBlock->findByBlockId($blockId);

		$ret = $this->AnnouncementBlocksPart->findByKeysOrDefault($announcementBlock['AnnouncementBlock']['id'], $partId);

		$this->assertEquals($ret[$this->AnnouncementBlocksPart->alias]['part_id'], 1);
		$this->assertTrue($ret[$this->AnnouncementBlocksPart->alias]['can_edit_content']);
		$this->assertTrue($ret[$this->AnnouncementBlocksPart->alias]['can_publish_content']);
		$this->assertFalse($ret[$this->AnnouncementBlocksPart->alias]['can_send_mail']);

		// 該当データなし
		$ret = $this->AnnouncementBlocksPart->findByKeysOrDefault(0, $partId);

		// デフォルト値かどうか。
		$this->assertEquals($ret[$this->AnnouncementBlocksPart->alias]['part_id'], 1);
		$this->assertTrue($ret[$this->AnnouncementBlocksPart->alias]['can_edit_content']);
		$this->assertTrue($ret[$this->AnnouncementBlocksPart->alias]['can_publish_content']);
		$this->assertTrue($ret[$this->AnnouncementBlocksPart->alias]['can_send_mail']);
	}

}
