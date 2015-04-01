<?php
/**
 * Announcement Model Test Case
 *
 * @property Announcement $Announcement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementAppModelTest', 'Announcements.Test/Case/Model');

/**
 * Announcement Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model
 */
class AnnouncementTest extends AnnouncementAppModelTest {

/**
 * Expect user w/ content_editable privilege can read content yet published
 *
 * @return void
 */
	public function testGetAnnouncement() {
		$blockId = 1;
		$contentEditable = true;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);
		$this->assertEqual(2, $result['Announcement']['id']);
	}

/**
 * Expect user w/o content_editable privilege cannot read content yet published
 *
 * @return void
 */
	public function testGetAnnouncementByNoEditable() {
		$blockId = 4;
		$contentEditable = false;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);
		$this->assertEmpty($result);
	}

/**
 * Expect user w/o content_editable privilege can read content published
 *
 * @return void
 */
	public function testGetAnnouncementByNoEditable2() {
		$blockId = 1;
		$contentEditable = false;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);
		$this->assertNotEmpty($result);
	}

/**
 * Expect Announcement->saveAnnouncement() saves data w/ numeric block_id
 *
 * @return void
 */
	public function testSaveAnnouncement() {
		$frameId = 1;
		$blockId = 3;

		$data = [
			'Announcement' => [
				'block_id' => $blockId,
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_IN_DRAFT,
				'content' => 'edit content',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			],
			'Frame' => [
				'id' => $frameId
			],
			'Comment' => [
				'comment' => 'edit comment',
			],
		];
		$expectCount = $this->Announcement->find('count', ['recursive' => -1]) + 1;
		$this->Announcement->saveAnnouncement($data);
		$this->assertEquals($expectCount, $this->Announcement->find('count', ['recursive' => -1]));
	}

/**
 * Expect Announcement->saveAnnouncement() saves data w/ null block_id
 *
 * @return void
 */
	public function testSaveAnnouncementByNoBlockId() {
		$frameId = 3;
		$blockId = null;

		$data = [
			'Announcement' => [
				'block_id' => $blockId,
				'status' => NetCommonsBlockComponent::STATUS_IN_DRAFT,
				'content' => 'add content',
				'is_auto_translated' => true,
				'translation_engine' => 'add translation_engine',
				'key' => 'announcement_1',
			],
			'Frame' => [
				'id' => $frameId
			],
			'Comment' => [
				'comment' => 'add comment',
			]
		];
		$expectCount = $this->Announcement->find('count', ['recursive' => -1]) + 1;
		$this->Announcement->saveAnnouncement($data);
		$this->assertEquals($expectCount, $this->Announcement->find('count', ['recursive' => -1]));
	}

/**
 * Expect Announcement->saveAnnouncement() fail on announcement save
 * e.g.) connection error
 *
 * @return void
 */
	public function testSaveAnnouncementFailOnAnnouncementSave() {
		$this->setExpectedException('InternalErrorException');

		$announcementMock = $this->getMockForModel('Announcements.Announcement', ['save']);
		$announcementMock->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$announcementMock->saveAnnouncement([
			'Announcement' => [
				'block_id' => null,
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_IN_DRAFT,
				'content' => 'edit content',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			],
			'Frame' => [
				'id' => 4
			],
			'Comment' => [
				'comment' => 'edit comment',
			]
		]);
	}

/**
 * Expect Announcement->saveAnnouncement() fail on comment save
 * e.g.) connection error
 *
 * @return void
 */
	public function testSaveAnnouncementFailOnCommentSave() {
		$this->setExpectedException('InternalErrorException');
		$announcementMock = $this->getMockForModel('Announcements.Announcement', ['save']);
		$announcementMock->expects($this->any())
			->method('save')
			->will($this->returnValue(true));

		$commentMock = $this->getMockForModel('Comments.Comment', ['save']);
		$commentMock->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$announcementMock->saveAnnouncement([
			'Announcement' => [
				'block_id' => null,
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_IN_DRAFT,
				'content' => 'edit content',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			],
			'Frame' => [
				'id' => 4
			],
			'Comment' => [
				'comment' => 'edit comment',
			]
		]);
	}
}
