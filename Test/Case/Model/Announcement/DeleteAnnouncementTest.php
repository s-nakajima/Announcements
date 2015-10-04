<?php
/**
 * Announcement::deleteAnnouncement()のテスト
 *
 * @property Announcement $Announcement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementTestBase', 'Announcements.Test/Case/Model/Announcement');

/**
 * Announcement::deleteAnnouncement()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementDeleteAnnouncementTest extends AnnouncementTestBase {

/**
 * Announcement::deleteAnnouncement()のテスト
 *
 * @return void
 */
	public function testDeleteAnnouncement() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = true;
		$data = $this->data;

		//テスト実行
		$result = $this->Announcement->deleteAnnouncement($data);
		$this->assertTrue($result);

		//評価
		$count = $this->Announcement->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $this->data['Announcement']['key']),
		));
		$this->assertEquals(0, $count);

		$count = $this->Announcement->WorkflowComment->find('count', array(
			'recursive' => -1,
			'conditions' => array('content_key' => $this->data['Announcement']['key']),
		));
		$this->assertEquals(0, $count);

		$count = $this->Block->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $this->data['Block']['key']),
		));
		$this->assertEquals(0, $count);

		$count = $this->Frame->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_id' => $this->data['Block']['id']),
		));
		$this->assertEquals(0, $count);
	}

/**
 * Announcement::deleteAnnouncement()のExceptionErrorテスト
 *
 * @return void
 */
	public function testDeleteExceptionError() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		$data = $this->data;

		$Mock = $this->getMockForModel('Announcements.Announcement', ['deleteAll']);
		$Mock->expects($this->once())
			->method('deleteAll')
			->will($this->returnValue(false));

		$this->setExpectedException('InternalErrorException');
		$Mock->deleteAnnouncement($data);
	}

}
