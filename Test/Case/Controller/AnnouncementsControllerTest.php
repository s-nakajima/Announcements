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
		$result = $this->testAction('/announcements/announcements/index');
		$this->assertTextContains(__('Content not found.'), $result);

		$result = $this->testAction('/announcements/announcements/index/2');
		$this->assertTextContains(__('Content not found.'), $result);

		$result = $this->testAction('/announcements/announcements/index/1');
		$this->assertTextContains('NetCommonsはCMS（Contents Management System)とLMS（Learning Management System)とグループウェアを統合したコミュニティウェアです。', $result);
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
		$result = $this->testAction('/announcements/announcements/edit');
		$this->assertTextContains(__('Content not found.'), $result);

		// 該当データなし
		$result = $this->testAction('/announcements/announcements/edit/2');
		$this->assertRegExp('/<form/', $result);
		$this->assertRegExp('/><\/textarea>/', $result);

		// 該当データあり
		$result = $this->testAction('/announcements/announcements/edit/1');
		$this->assertTextContains('NetCommonsはCMS（Contents Management System)とLMS（Learning Management System)とグループウェアを統合したコミュニティウェアです。', $result);
		$this->assertRegExp('/<form/', $result);

		// 登録
		$content = 'Update!';
		// 該当データなし
		$data = array(
			'Announcement' => array(
				'id' => 0,
				'block_id' => 2,
				'is_published' => 1,
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
		$this->assertEquals($results['AnnouncementRevision']['status_id'], 1);

		// 該当データあり
		$data = array(
			'Announcement' => array(
				'id' => 10,
				'block_id' => 1,
				'is_published' => 0,
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
		$this->assertEquals($results['AnnouncementRevision']['status_id'], 0);

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
 * testBlock method
 *
 * @return void
 */
	public function testBlock() {
		$result = $this->testAction('/announcements/announcements/block');
		$this->assertTextContains(__('Content not found.'), $result);

		// 該当データなし
		$result = $this->testAction('/announcements/announcements/block/2');
		$this->assertRegExp('/<form/', $result);
		$this->assertTextNotContains('Mail Subject', $result);

		// 該当データあり
		$result = $this->testAction('/announcements/announcements/block/1');
		$this->assertRegExp('/<form/', $result);
		$this->assertTextContains('Mail Subject', $result);

		// 登録
		// 該当データなし
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
					'can_create_content' => 1,
					'can_publish_content' => 1,
					'can_send_mail' => '0',
				),
				array(
					'id' => 0,
					'announcement_block_id' => 0,
					'part_id' => 2,
					'can_create_content' => 1,
					'can_publish_content' => 1,
					'can_send_mail' => 0,
				),
				array(
					'id' => 0,
					'announcement_block_id' => 0,
					'part_id' => 3,
					'can_create_content' => 0,
					'can_publish_content' => 0,
					'can_send_mail' => 0,
				),
				array(
					'id' => '0',
					'announcement_block_id' => 0,
					'part_id' => 4,
					'can_create_content' => 0,
					'can_publish_content' => 0,
					'can_send_mail' => 0,
				)
			),
		);
		$this->testAction(
			'/announcements/announcements/block/2',
			array('data' => $data, 'method' => 'post')
		);

		$results = $this->AnnouncementBlock->findByBlockId(2);
		$this->assertEquals($results['AnnouncementBlock']['mail_subject'], 'Mail Subject');

		// 該当データあり
		$data = array(
			'AnnouncementBlock' => array(
				'id' => 10,
				'block_id' => 1,
				'send_mail' => 0,
				'mail_subject' => 'Mail Subject2',
				'mail_body' => 'Mail Body2'
			),
			'AnnouncementBlocksPart' => array(
				array(
					'id' => 10,
					'announcement_block_id' => 10,
					'part_id' => 1,
					'can_create_content' => 1,
					'can_publish_content' => 1,
					'can_send_mail' => 0,
				),
				array(
					'id' => 11,
					'announcement_block_id' => 10,
					'part_id' => 2,
					'can_create_content' => 1,
					'can_publish_content' => 1,
					'can_send_mail' => 0,
				),
				array(
					'id' => 12,
					'announcement_block_id' => 10,
					'part_id' => 3,
					'can_create_content' => 0,
					'can_publish_content' => 0,
					'can_send_mail' => 0,
				),
				array(
					'id' => 13,
					'announcement_block_id' => 10,
					'part_id' => 4,
					'can_create_content' => 0,
					'can_publish_content' => 0,
					'can_send_mail' => 0,
				)
			),
		);
		$this->testAction(
			'/announcements/announcements/block/1',
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
			'/announcements/announcements/block/1',
			array('data' => $data, 'method' => 'put')
		);
	}

}
