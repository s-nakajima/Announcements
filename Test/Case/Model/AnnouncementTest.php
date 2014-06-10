<?php
/**
 * Announcement Test Case
 *
 * @author   @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Announcement', 'Announcements.Model');

/**
 * Summary for Announcement Test Case
 */
class AnnouncementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Announcement = ClassRegistry::init('Announcements.Announcement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Announcement);
		parent::tearDown();
	}

	public function testSaveBlockId()
	{
		$d['Announcement']['block_id'] = 1;
		$d['Announcement']['create_user_id'] = 1;
		$mine = $this->Announcement->save($d);
		$this->assertTrue(is_numeric($mine['Announcement']['id']));
	}

	public function testGetByBlockId() {
		//blockId1のデータを作成
		$d['Announcement']['block_id'] = 1;
		$d['Announcement']['create_user_id'] = 1;
		$mine = $this->Announcement->save($d);
		$this->assertTrue(is_numeric($mine['Announcement']['id']));

		$data = $this->Announcement->getByBlockId(1);
		$this->assertTrue(is_numeric($data));
	}

	public function testGetByBlockIdNoData() {
		//blockId1のデータを作成
		$d['Announcement']['block_id'] = 1;
		$d['Announcement']['create_user_id'] = 1;
		$mine = $this->Announcement->save($d);
		$this->assertTrue(is_numeric($mine['Announcement']['id']));
		$data = $this->Announcement->getByBlockId(100);
		$this->assertNull($data);
	}

}
