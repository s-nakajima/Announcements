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

App::uses('WorkflowSaveTest', 'Workflow.TestSuite');

/**
 * Announcement::saveAnnouncement()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementSaveAnnouncementTest extends WorkflowSaveTest {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'announcements';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
		'plugin.announcements.workflow_comment4announcements',
	);

/**
 * data
 *
 * @var array
 */
	public $data = array(
		'Frame' => array(
			'id' => '6'
		),
		'Block' => array(
			'id' => '2',
			'language_id' => '2',
			'room_id' => '1',
			'key' => 'block_1',
			'plugin_key' => 'announcements',
		),
		'Announcement' => array(
			'id' => '2',
			'language_id' => '2',
			'block_id' => '2',
			'key' => 'announcement_1',
			'status' => WorkflowComponent::STATUS_PUBLISHED,
			'content' => 'Announcement save test'
		),
		'WorkflowComment' => array(
			'comment' => 'WorkflowComment save test'
		),
	);

/**
 * SaveのDataProvider
 *
 * @return void
 */
	public function dataProviderSave() {
		return array(
			array($this->data, 'Announcement', 'saveAnnouncement'),
		);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->data, 'Announcement', 'saveAnnouncement', 'Announcements.Announcement', 'save'),
		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * @return void
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->data, 'Announcement', 'saveAnnouncement', 'Announcements.Announcement'),
		);
	}

/**
 * ValidationErrorのDataProvider
 *
 * @return void
 */
	public function dataProviderValidationError() {
		return array(
			array($this->data, 'Announcement', 'content', '',
				sprintf(__d('net_commons', 'Please input %s.'), __d('announcements', 'Content'))),
			array($this->data, 'Announcement', 'block_id', 'aaa',
				__d('net_commons', 'Invalid request.')),
		);
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @param string $model モデル名
 * @param string $method メソッド
 * @dataProvider dataProviderSave
 * @return void
 */
	//public function testSave($data, $model, $method) {
	//	parent::testSave($data, $model, $method);
	//}

}
