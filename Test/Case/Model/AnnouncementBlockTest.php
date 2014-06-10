<?php
/**
 * AnnouncementBlock Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
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
		'plugin.announcements.announcement_block'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementBlock = ClassRegistry::init('Announcements.AnnouncementBlock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementBlock);
		parent::tearDown();
	}

   public function testSave(){
		$data['AnnouncementBlock'] = array(
			'block_id'=>9999999999,
			'send_mail'=>1,
			'mail_subject'=>'test',
			'mail_body'=>'test body',
			'create_user_id'=>1
		);
		$rtn = $this->AnnouncementBlock->save($data);
		$this->assertTrue(is_numeric($rtn['AnnouncementBlock']['id']));
   }

}
