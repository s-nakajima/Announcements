<?php
/**
 * AnnouncementsController Test Case
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsController', 'Announcements.Controller');

/**
 * Summary for AnnouncementsController Test Case
 */
class AnnouncementsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'site_setting',
		'site_setting_value',
		'plugin.announcements.announcement',
		'plugin.announcements.announcement_revision',
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
		$this->Announcement = ClassRegistry::init('Announcements.Announcement');
		$this->AnnouncementBlock = ClassRegistry::init('Announcements.AnnouncementBlock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Announcement);
		unset($this->AnnouncementBlock);
		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		// block_id指定なし
		$result = $this->testAction('/announcements/announcements/index');
		$this->assertTextContains(__('Content not found.'), $result);

		// 存在しないblock_idを指定
		$result = $this->testAction('/announcements/announcements/index/2');
		$this->assertTextContains(__('Content not found.'), $result);

		// 存在するblock_idを指定
		$result = $this->testAction('/announcements/announcements/index/1');
		$this->assertTextContains('Test1', $result);
	}

/**
 * testEdit method 表示
 *
 * @return void
 */
	public function testEditGet() {
		$result = $this->testAction('/announcements/announcements/edit');
		$this->assertTextContains(__('Content not found.'), $result);

		// 存在しないblock_idを指定
		$result = $this->testAction('/announcements/announcements/edit/2');
		$this->assertRegExp('/<form/', $result);
		$this->assertRegExp('/><\/textarea>/', $result);

		// 存在するblock_idを指定
		$result = $this->testAction('/announcements/announcements/edit/1');
		$this->assertTextContains('Test1', $result);
		$this->assertRegExp('/<form/', $result);
	}

/**
 * testEdit method 登録
 *
 * @return void
 */
	public function testEditPost() {
		Configure::load('Revision.config');
		$statusId = Configure::read('Revision.status_id');
		// 登録
		$content = 'Update!';
		// 存在しないblock_idを指定
		$data = array(
			'Announcement' => array(
				'id' => 0,
				'block_id' => 2,
				'is_published' => true,
			),
			'AnnouncementRevision' => array(
				'id' => 0,
				'content' => $content,
			),
		);
		$this->testAction(
			'/announcements/announcements/edit/2',
			array('data' => $data, 'method' => 'post')
		);
		$this->assertContains('/announcements/announcements/index/2', $this->headers['Location']);

		$results = $this->Announcement->findByBlockId(2);
		$this->assertEquals($results['AnnouncementRevision']['content'], $content);
		$this->assertEquals($results['AnnouncementRevision']['status_id'], $statusId['published']);

		// 存在するblock_idを指定
		$data = array(
			'Announcement' => array(
				'id' => 10,
				'block_id' => 1,
				'is_published' => false,
			),
			'AnnouncementRevision' => array(
				'id' => 1,
				'content' => $content,
			),
		);
		$this->testAction(
			'/announcements/announcements/edit/1',
			array('data' => $data, 'method' => 'put')
		);
		$this->assertContains('/announcements/announcements/index/1', $this->headers['Location']);

		$results = $this->Announcement->findByBlockId(1);
		$this->assertEquals($results['AnnouncementRevision']['content'], $content);
		$this->assertEquals($results['AnnouncementRevision']['status_id'], $statusId['draft']);

		// save Error
		$Announcements = $this->generate('Announcements', array(
			'models' => array(
				'Announcement' => array('save')
			)
		));
		$Announcements->Announcement->expects($this->once())->method('save')
			->will($this->returnValue(false));

		$this->setExpectedException('InternalErrorException');

		$this->testAction(
			'/announcements/announcements/edit/1',
			array('data' => $data, 'method' => 'put')
		);
	}

/**
 * testBlockSettingGet method 表示
 *
 * @return void
 */
	public function testBlockSettingGet() {
		$result = $this->testAction('/announcements/announcements/block_setting');
		$this->assertTextContains(__('Content not found.'), $result);

		// 存在しないblock_idを指定
		$result = $this->testAction('/announcements/announcements/block_setting/2');
		$this->assertRegExp('/<form/', $result);
		$this->assertTextNotContains('Mail Subject', $result);

		// 存在するblock_idを指定
		$result = $this->testAction('/announcements/announcements/block_setting/1');
		$this->assertRegExp('/<form/', $result);
		$this->assertTextContains('Mail Subject', $result);
	}

/**
 * testBlockSettingPost method 登録(存在しないblock_idを指定)
 *
 * @return void
 */
	public function testBlockSettingPostNotExists() {
		$data = array(
			'AnnouncementBlock' => array(
				'id' => 0,
				'block_id' => 2,
				'send_mail' => 0,
				'mail_subject' => 'Mail Subject',
				'mail_body' => 'Mail Body'
			),
			'AnnouncementBlocksPart' => array(
				array(
					'id' => 0,
					'announcement_block_id' => 0,
					'part_id' => 1,
					'can_create_content' => true,
					'can_publish_content' => true,
					'can_send_mail' => false,
				),
				array(
					'id' => 0,
					'announcement_block_id' => 0,
					'part_id' => 2,
					'can_create_content' => true,
					'can_publish_content' => true,
					'can_send_mail' => false,
				),
				array(
					'id' => 0,
					'announcement_block_id' => 0,
					'part_id' => 3,
					'can_create_content' => false,
					'can_publish_content' => false,
					'can_send_mail' => false,
				),
				array(
					'id' => '0',
					'announcement_block_id' => 0,
					'part_id' => 4,
					'can_create_content' => false,
					'can_publish_content' => false,
					'can_send_mail' => false,
				)
			),
		);
		$this->testAction(
			'/announcements/announcements/block_setting/2',
			array('data' => $data, 'method' => 'post')
		);

		$results = $this->AnnouncementBlock->findByBlockId(2);
		$this->assertEquals($results['AnnouncementBlock']['mail_subject'], 'Mail Subject');
	}

/**
 * testBlockSettingPostExists method 登録(存在するblock_idを指定)
 *
 * @return void
 */
	public function testBlockSettingPostExists() {
		// 存在するblock_idを指定
		$data = array(
			'AnnouncementBlock' => array(
				'id' => 10,
				'block_id' => 1,
				'send_mail' => false,
				'mail_subject' => 'Mail Subject2',
				'mail_body' => 'Mail Body2'
			),
			'AnnouncementBlocksPart' => array(
				array(
					'id' => 10,
					'announcement_block_id' => 10,
					'part_id' => 1,
					'can_create_content' => true,
					'can_publish_content' => true,
					'can_send_mail' => false,
				),
				array(
					'id' => 11,
					'announcement_block_id' => 10,
					'part_id' => 2,
					'can_create_content' => true,
					'can_publish_content' => true,
					'can_send_mail' => false,
				),
				array(
					'id' => 12,
					'announcement_block_id' => 10,
					'part_id' => 3,
					'can_create_content' => false,
					'can_publish_content' => false,
					'can_send_mail' => false,
				),
				array(
					'id' => 13,
					'announcement_block_id' => 10,
					'part_id' => 4,
					'can_create_content' => false,
					'can_publish_content' => false,
					'can_send_mail' => false,
				)
			),
		);
		$this->testAction(
			'/announcements/announcements/block_setting/1',
			array('data' => $data, 'method' => 'put')
		);

		$results = $this->AnnouncementBlock->findByBlockId(1);
		$this->assertEquals($results['AnnouncementBlock']['mail_subject'], 'Mail Subject2');

		// save Error
		$Announcements = $this->generate('Announcements', array(
			'models' => array(
				'AnnouncementBlock' => array('save')
			)
		));
		$Announcements->AnnouncementBlock->expects($this->once())->method('save')
			->will($this->returnValue(false));

		$this->setExpectedException('InternalErrorException');

		$this->testAction(
			'/announcements/announcements/block_setting/1',
			array('data' => $data, 'method' => 'put')
		);
	}

}
