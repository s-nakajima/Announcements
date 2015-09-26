<?php
/**
 * Announcement::validates()のテスト
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
 * Announcement::validates()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementValidationErrorTest extends AnnouncementTestBase {

/**
 * Announcement.contentのnotBlankエラー
 *
 * @return void
 */
	public function testContentByNotBlank() {
		$this->_assertValidation('notBlank', 'Announcement', 'Announcement.content', true);
	}

/**
 * Announcement.block_idのNumericエラー
 *
 * @return void
 */
	public function testBlockIdByNumeric() {
		$this->data['Announcement']['id'] = '2';
		$this->_assertValidation('numeric', 'Announcement', 'Announcement.block_id');
		unset($this->data['Announcement']['id']);
	}

/**
 * Announcement.statusのWorkflowStatusエラー
 *
 * @return void
 */
	public function testStatusByWorkflowStatus() {
		$this->_assertValidation('workflowStatus', 'Announcement', 'Announcement.status');
	}

}
