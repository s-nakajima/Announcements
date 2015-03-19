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
 * Announcement Model Test Case for validation errors
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model
 */
class AnnouncementValidateErrorTest extends AnnouncementAppModelTest {

/**
 * Expect Announcement->saveAnnouncement() to validate announcements.status and return false on validation error
 *
 * @return void
 */
	public function testSaveAnnouncemenByStatus() {
		$data = array(
			'Announcement' => array(
				'block_id' => 1,
				'key' => 'announcement_1',
				'content' => 'edit content',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
				'comment' => 'edit comment',
			)
		);
		$result = $this->Announcement->saveAnnouncement($data);
		$this->assertFalse($result, 'saveAnnouncement test No.0 data = ' . print_r($data, true));

		$checks = array(
			null, '', -1, 0, 5, 9999, 'abcde',
		);
		foreach ($checks as $i => $check) {
			$data['Announcement']['status'] = $check;
			$result = $this->Announcement->saveAnnouncement($data);
			$this->assertFalse($result, 'saveAnnouncement test No.' . ($i + 1) . print_r($data, true));
		}
	}

/**
 * Expect Announcement->saveAnnouncement() to validate announcements.content and return false on validation error
 *
 * @return void
 */
	public function testSaveAnnouncementByContent() {
		$data = array(
			'Announcement' => array(
				'block_id' => 1,
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_IN_DRAFT,
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
				'comment' => 'edit comment',
			)
		);
		$result = $this->Announcement->saveAnnouncement($data);
		$this->assertFalse($result, 'saveAnnouncement test No.0 data = ' . print_r($data, true));

		$checks = array(
			null, '',
		);
		foreach ($checks as $i => $check) {
			$data['Announcement']['content'] = $check;
			$result = $this->Announcement->saveAnnouncement($data);
			$this->assertFalse($result, 'saveAnnouncement test No.' . ($i + 1) . print_r($data, true));
		}
	}

/**
 * Expect Announcement->saveAnnouncement() to validate comments.comment and return false on validation error
 *
 * @return void
 */
	public function testSaveAnnouncemenByComment() {
		$data = array(
			'Announcement' => array(
				'block_id' => 1,
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
				'content' => 'edit content',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
			)
		);
		$result = $this->Announcement->saveAnnouncement($data);
		$this->assertFalse($result, 'saveAnnouncement test No.0 data = ' . print_r($data, true));

		$checks = array(
			null, '',
		);
		foreach ($checks as $i => $check) {
			$data['Comment']['comment'] = $check;
			$result = $this->Announcement->saveAnnouncement($data);
			$this->assertFalse($result, 'saveAnnouncement test No.' . ($i + 1) . print_r($data, true));
		}
	}
}
