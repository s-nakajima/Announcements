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
class AnnouncementErrorTest extends AnnouncementAppModelTest {

/**
 * Expect Announcement->saveAnnouncement() to validate frames.id and throw exception on error
 *
 * @return void
 */
	public function testSaveAnnouncementByUnknownFrameId() {
		$this->setExpectedException('InternalErrorException');

		$data = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_APPROVED,
				'content' => 'edit content',
			),
			'Frame' => array(
				'id' => -1
			),
			'Comment' => array(
				'comment' => 'edit comment',
			)
		);

		$this->Announcement->saveAnnouncement($data);
	}
}
