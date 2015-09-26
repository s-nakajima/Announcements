<?php
/**
 * Announcement::saveAnnouncement()のテスト
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
App::uses('WorkflowSaveTest', 'Workflow.TestSuite');

/**
 * Announcement::saveAnnouncement()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementSaveAnnouncementTest extends AnnouncementTestBase implements WorkflowSaveTest {

/**
 * Announcement::saveAnnouncement()テストの共通処理
 *
 * @return void
 */
	private function __testSave($data, $expected = array()) {
		//処理実行
		$result = $this->Announcement->saveAnnouncement($data);
		$this->assertNotEmpty($result);
		$announcementId = $this->Announcement->getLastInsertID();

		$result = $this->Announcement->getAnnouncement();
		$this->assertEquals($result['Block']['name'], $result['Announcement']['content']);
		unset($result['Block']['name']);

		//期待値
		$expected = Hash::merge($data, array(
			'Announcement' => array(
				'id' => $announcementId,
				'is_active' => true,
				'is_latest' => true,
			),
			'Block' => array(
				'public_type' => '1',
				'from' => null,
				'to' => null
			),
		), $expected);
		unset($expected['Frame'], $expected['Comment']);

		//評価
		$this->_assertData($expected, $result);
	}

/**
 * Announcement::saveAnnouncement()のテスト(WorkflowComponent::STATUS_PUBLISHED)
 *
 * @return void
 */
	public function testSaveByStatusPublished() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = true;
		$data = $this->data;
		$data['Announcement']['status'] = WorkflowComponent::STATUS_PUBLISHED;

		//テスト実行
		$this->__testSave($data, array(
			'Announcement' => array(
				'is_active' => true,
			))
		);
	}

/**
 * Announcement::saveAnnouncement()のテスト(WorkflowComponent::STATUS_APPROVED)
 *
 * @return void
 */
	public function testSaveByStatusApproved() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = false;
		$data = $this->data;
		$data['Announcement']['status'] = WorkflowComponent::STATUS_APPROVED;

		//テスト実行
		$this->__testSave($data, array(
			'Announcement' => array(
				'is_active' => false,
			))
		);
	}

/**
 * Announcement::saveAnnouncement()のテスト(WorkflowComponent::STATUS_IN_DRAFT)
 *
 * @return void
 */
	public function testSaveByStatusInDraft() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = false;
		$data = $this->data;
		$data['Announcement']['status'] = WorkflowComponent::STATUS_IN_DRAFT;

		//テスト実行
		$this->__testSave($data, array(
			'Announcement' => array(
				'is_active' => false,
			))
		);
	}

/**
 * Announcement::saveAnnouncement()のテスト(WorkflowComponent::STATUS_DISAPPROVED)
 *
 * @return void
 */
	public function testSaveByStatusDisapproved() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = true;
		$data = $this->data;
		$data['Announcement']['status'] = WorkflowComponent::STATUS_DISAPPROVED;

		//テスト実行
		$this->__testSave($data, array(
			'Announcement' => array(
				'is_active' => false,
			))
		);
	}

/**
 * Announcement::saveAnnouncement()のExceptionErrorテスト
 *
 * @return void
 */
	public function testSaveExceptionError() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = true;
		$data = $this->data;

		$Mock = $this->getMockForModel('Announcements.Announcement', ['save']);
		$Mock->expects($this->once())
			->method('save')
			->will($this->returnValue(false));

		$this->setExpectedException('InternalErrorException');
		$Mock->saveAnnouncement($data);
	}

/**
 * Announcement::saveAnnouncement()のValidationErrorテスト
 *
 * @return void
 */
	public function testSaveValidationError() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		Current::$current['Permission']['content_publishable']['value'] = true;
		$data = $this->data;

		$Mock = $this->getMockForModel('Announcements.Announcement', ['validates']);
		$Mock->expects($this->once())
			->method('validates')
			->will($this->returnValue(false));

		$result = $Mock->saveAnnouncement($data);
		$this->assertFalse($result);
	}

}
