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

App::uses('WorkflowDeleteTest', 'Workflow.TestSuite');

/**
 * Announcement::deleteAnnouncement()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementDeleteAnnouncementTest extends WorkflowDeleteTest {

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
		'Block' => array(
			'id' => '2',
			'key' => 'block_1',
		),
		'Announcement' => array(
			'key' => 'announcement_1',
		),
	);

/**
 * DeleteのDataProvider
 *
 * ### 戻り値
 *  - data: 削除データ
 *  - model: モデル名
 *  - method: メソッド
 *
 * @return void
 */
	public function dataProviderDelete() {
		return array(
			array($this->data, 'Announcement', 'deleteAnnouncement'),
		);
	}

/**
 * ExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - model モデル名
 *  - method メソッド
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderDeleteOnExceptionError() {
		return array(
			array($this->data, 'Announcement', 'deleteAnnouncement', 'Announcements.Announcement', 'deleteAll'),
		);
	}

/**
 * Deleteのテスト
 *
 * @param array $data 削除データ
 * @param string $model モデル名
 * @param string $method メソッド
 * @dataProvider dataProviderDelete
 * @return void
 */
	//public function testDelete($data, $model, $method) {
	//	parent::testDelete($data, $model, $method);
	//}

}
