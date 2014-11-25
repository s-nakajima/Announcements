<?php
/**
 * AnnouncementEditController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsController', 'Announcements.Controller');
App::uses('AnnouncementsAppTest', 'Announcements.Test/Case/Controller');

/**
 * AnnouncementEditController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerValidateErrorTest extends AnnouncementsAppTest {

/**
 * testEditContentError method
 *
 * @return void
 */
	public function testEditContentError() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginAdmin();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => '',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
				'comment' => 'edit comment',
			)
		);

		$view = $this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);

		$result = json_decode($view, true);

		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));
		$this->assertArrayHasKey('name', $result, print_r($result, true));
		$this->assertArrayHasKey('results', $result, print_r($result, true));
		$this->assertArrayHasKey('validationErrors', $result['results'], print_r($result, true));
		$this->assertArrayHasKey('content', $result['results']['validationErrors'], print_r($result, true));

		$this->_logout();
	}

/**
 * testEditCommentError method
 *
 * @return void
 */
	public function testEditCommentError() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginAdmin();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
				'content' => 'edit content',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
				'comment' => '',
			)
		);

		$view = $this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);

		$result = json_decode($view, true);

		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));
		$this->assertArrayHasKey('name', $result, print_r($result, true));
		$this->assertArrayHasKey('results', $result, print_r($result, true));
		$this->assertArrayHasKey('validationErrors', $result['results'], print_r($result, true));
		$this->assertArrayHasKey('comment', $result['results']['validationErrors'], print_r($result, true));

		$this->_logout();
	}
}
