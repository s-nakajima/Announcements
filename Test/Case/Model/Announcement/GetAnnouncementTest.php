<?php
/**
 * Announcement::getAnnouncement()のテスト
 *
 * @property Announcement $Announcement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowGetTest', 'Workflow.TestSuite');

/**
 * Announcement::getAnnouncement()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementGetAnnouncementTest extends WorkflowGetTest {

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
		'plugin.announcements.block_setting_for_announcement',
		'plugin.workflow.workflow_comment',
	);

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'Announcement';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'getAnnouncement';

/**
 * 編集権限なしのテスト
 *
 * @return void
 */
	public function testGetAnnouncementWOContentEditable() {
		//事前データセット
		Current::$current['Permission']['content_editable']['value'] = false;
		$announcementId = '1';

		//期待値
		$expected = $this->Announcement->findById($announcementId);

		//テスト実施
		$result = $this->Announcement->getAnnouncement();
		$result = Hash::remove($result, 'AnnouncementSetting');
		$result = Hash::remove($result, 'BlocksLanguage');

		//チェック
		$this->assertEquals($result, $expected);
	}

/**
 * 編集権限ありのテスト
 *
 * @return void
 */
	public function testGetAnnouncementContentEditable() {
		//事前データセット
		$announcementId = '2';

		//期待値
		$expected = $this->Announcement->findById($announcementId);

		//テスト実施
		$result = $this->Announcement->getAnnouncement();
		$result = Hash::remove($result, 'AnnouncementSetting');
		$result = Hash::remove($result, 'BlocksLanguage');

		//チェック
		$this->assertEquals($result, $expected);
	}

}
