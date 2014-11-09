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
class AnnouncementErrorTest extends AnnouncementAppModelTest {

/**
 * testSaveAnnouncementByErrorFrameId method
 *
 * @return void
 */
	public function testSaveAnnouncementByErrorFrameId() {
		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'change data',
			),
			'Frame' => array(
				'id' => '10'
			)
		);
		$result = $this->Announcement->saveAnnouncement($postData);
		$this->assertFalse($result, 'saveAnnouncement');
	}

/**
 * testSaveAnnouncementByBlockSaveError method
 *
 * @return void
 */
	public function testSaveAnnouncementByBlockSaveError() {
		$this->Block = $this->getMockForModel('Blocks.Block', array('save'));
		$this->Block->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$postData = array(
			'Announcement' => array(
				'status' => '1',
				'content' => 'add data',
			),
			'Frame' => array(
				'id' => '3'
			)
		);
		$result = $this->Announcement->saveAnnouncement($postData);
		$this->assertFalse($result);
	}

/**
 * testSaveAnnouncementByFrameSaveError method
 *
 * @return void
 */
	public function testSaveAnnouncementByFrameSaveError() {
		$this->Frame = $this->getMockForModel('Frames.Frame', array('save'));
		$this->Frame->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$postData = array(
			'Announcement' => array(
				'status' => '1',
				'content' => 'add data',
			),
			'Frame' => array(
				'id' => '3'
			)
		);
		$result = $this->Announcement->saveAnnouncement($postData);
		$this->assertFalse($result);

		unset($this->Frame);
	}
}
