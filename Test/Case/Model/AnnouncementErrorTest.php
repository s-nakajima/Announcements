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
 * logLevels
 *
 * @var array
 */
	public $logLevels = array();

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//異常(catch)テストでエラーTraceが必ず出力されてしまうため、ログ出力をOFFにする
		//また、Modelでは、CakeLog::error()を使うとNoticeが発生するため、CakeLog::write()を使って出力する
		$this->logLevels = CakeLog::levels();
		$setLevels = $this->logLevels;
		$setLevels[LOG_ERR] = '';
		CakeLog::levels($setLevels, false);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログ出力をONにする
		CakeLog::levels($this->logLevels, false);
		parent::tearDown();
	}

/**
 * testSaveAnnouncementByErrorFrameId method
 *
 * @return void
 */
	public function testSaveAnnouncementByErrorFrameId() {
		$this->setExpectedException('InternalErrorException');

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'edit content',
			),
			'Frame' => array(
				'id' => '10'
			),
			'Comment' => array(
				'comment' => 'edit comment',
			)
		);
		$this->Announcement->saveAnnouncement($postData);
	}

/**
 * testSaveAnnouncementByFrameSaveError method
 *
 * @return void
 */
	public function testSaveAnnouncementByFrameSaveError() {
		$this->setExpectedException('InternalErrorException');

		$this->Frame = $this->getMockForModel('Frames.Frame', array('save'));
		$this->Frame->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$postData = array(
			'Announcement' => array(
				'status' => '1',
				'content' => 'add content',
				'block_id' => '0'
			),
			'Frame' => array(
				'id' => '3'
			),
			'Comment' => array(
				'comment' => 'edit comment',
			)
		);
		$this->Announcement->saveAnnouncement($postData);

		unset($this->Frame);
	}

/**
 * testSaveAnnouncementBySaveError method
 *
 * @return void
 */
	public function testSaveAnnouncementBySaveError() {
		$this->setExpectedException('InternalErrorException');

		$this->Announcement = $this->getMockForModel('Announcements.Announcement', array('save'));
		$this->Announcement->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$postData = array(
			'Announcement' => array(
				'status' => '1',
				'content' => 'add content',
				'block_id' => '0'
			),
			'Frame' => array(
				'id' => '3'
			),
			'Comment' => array(
				'comment' => 'edit comment',
			)
		);
		$this->Announcement->saveAnnouncement($postData);

		unset($this->Announcement);
	}

/**
 * testSaveAnnouncementByCommentSaveError method
 *
 * @return void
 */
	public function testSaveAnnouncementByCommentSaveError() {
		$this->setExpectedException('InternalErrorException');

		$this->Comment = $this->getMockForModel('Comments.Comment', array('save'));
		$this->Comment->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$postData = array(
			'Announcement' => array(
				'status' => '1',
				'content' => 'add content',
				'block_id' => '0'
			),
			'Frame' => array(
				'id' => '3'
			),
			'Comment' => array(
				'comment' => 'edit comment',
			)
		);
		$this->Announcement->saveAnnouncement($postData);

		unset($this->Comment);
	}

}
