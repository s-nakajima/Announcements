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

App::uses('AnnouncementTestBase', 'Announcements.Test/Case/Model/Announcement');

/**
 * Announcement::getAnnouncement()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementGetAnnouncementTest extends AnnouncementTestBase {

/**
 * 正常テスト(ログインなし)
 *
 * @return void
 */
	public function testGetAnnouncement() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = false;
		$announcementId = '1';

		//期待値
		$expected = $this->Announcement->findById($announcementId);

		//テスト実施
		$result = $this->Announcement->getAnnouncement();

		//評価
		$this->_assertData($expected, $result);
	}

/**
 * 正常テスト(編集権限あり)
 *
 * @return void
 */
	public function testGetAnnouncementByContentEditable() {
		//事前データセット
		Current::$current['Block']['id'] = '2';
		Current::$current['Room']['id'] = '1';
		Current::$current['Language']['id'] = '2';
		Current::$current['Permission']['content_editable']['value'] = true;
		$announcementId = '2';

		//期待値
		$expected = $this->Announcement->findById($announcementId);

		//テスト実施
		$result = $this->Announcement->getAnnouncement();

		//評価
		$this->_assertData($expected, $result);

		//後処理
		Current::$current['Permission']['content_editable']['value'] = false;
	}

}
