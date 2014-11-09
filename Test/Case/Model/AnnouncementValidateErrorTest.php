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
 *Announcement Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model
 */
class AnnouncementValidateErrorTest extends AnnouncementAppModelTest {

/**
 * testSaveAnnouncemenByStatus method
 *
 * @return void
 */
	public function testSaveAnnouncemenByStatus() {
		$postData = array(
			'Announcement' => array(
				'block_id' => 1,
				'key' => 'announcement_1',
				'content' => 'edit content',
				'comment' => 'edit comment',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			),
			'Frame' => array(
				'id' => '1'
			)
		);
		$result = $this->Announcement->saveAnnouncement($postData);
		$this->assertFalse($result, 'saveAnnouncement test No.0 data = ' . print_r($postData, true));

		$checkes = array(
			null, '', -1, 0, 5, 9999, 'abcde',
		);
		foreach ($checkes as $i => $check) {
			$postData = array(
				'Announcement' => array(
					'block_id' => 1,
					'key' => 'announcement_1',
					'status' => $check,
					'content' => 'edit content',
					'comment' => 'edit comment',
					'is_auto_translated' => true,
					'translation_engine' => 'edit translation_engine',
				),
				'Frame' => array(
					'id' => '1'
				)
			);
			$result = $this->Announcement->saveAnnouncement($postData);
			$this->assertFalse($result, 'saveAnnouncement test No.' . ($i + 1) . print_r($postData, true));
		}
	}

/**
 * testSaveAnnouncemenByContent method
 *
 * @return void
 */
	public function testSaveAnnouncemenByContent() {
		$postData = array(
			'Announcement' => array(
				'block_id' => 1,
				'key' => 'announcement_1',
				'status' => '1',
				'comment' => 'edit comment',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			),
			'Frame' => array(
				'id' => '1'
			)
		);
		$result = $this->Announcement->saveAnnouncement($postData);
		$this->assertFalse($result, 'saveAnnouncement test No.0 data = ' . print_r($postData, true));

		$checkes = array(
			null, '',
		);
		foreach ($checkes as $i => $check) {
			$postData = array(
				'Announcement' => array(
					'block_id' => 1,
					'key' => 'announcement_1',
					'status' => '1',
					'content' => $check,
					'comment' => 'edit comment',
					'is_auto_translated' => true,
					'translation_engine' => 'edit translation_engine',
				),
				'Frame' => array(
					'id' => '1'
				)
			);
			$result = $this->Announcement->saveAnnouncement($postData);
			$this->assertFalse($result, 'saveAnnouncement test No.' . ($i + 1) . print_r($postData, true));
		}
	}

/**
 * testSaveAnnouncemenByContent method
 *
 * @return void
 */
	public function testSaveAnnouncemenByComment() {
		$postData = array(
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
			)
		);
		$result = $this->Announcement->saveAnnouncement($postData);
		$this->assertFalse($result, 'saveAnnouncement test No.0 data = ' . print_r($postData, true));

		$checkes = array(
			null, '',
		);
		foreach ($checkes as $i => $check) {
			$postData = array(
				'Announcement' => array(
					'block_id' => 1,
					'key' => 'announcement_1',
					'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
					'content' => 'edit content',
					'comment' => $check,
					'is_auto_translated' => true,
					'translation_engine' => 'edit translation_engine',
				),
				'Frame' => array(
					'id' => '1'
				)
			);
			$result = $this->Announcement->saveAnnouncement($postData);
			$this->assertFalse($result, 'saveAnnouncement test No.' . ($i + 1) . print_r($postData, true));
		}
	}
}
