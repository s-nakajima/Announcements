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
 * AnnouncementsController Validation Error Test Case based on models
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerValidateErrorTest extends AnnouncementsAppTest {

/**
 * Expect user cannot edit w/o valid announcements.status
 *
 * @return void
 */
	public function testEditWithInvalidStatus() {
		$this->_generateController('Announcements.Announcements');
		RolesControllerTest::login($this);

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'content' => '',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
				'comment' => 'edit comment',
			),
		);

		$this->setExpectedException('BadRequestException');
		$this->testAction(
				'/announcements/announcements/edit/1',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);
		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user cannot edit w/o valid announcements.status as ajax request
 *
 * @return void
 */
	public function testEditWithInvalidStatusJson() {
		$this->_generateController('Announcements.Announcements');
		RolesControllerTest::login($this);

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'content' => 'announcement',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
				'comment' => 'edit comment',
			),
		);

		$ret = $this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'type' => 'json',
					'return' => 'contents'
				)
			);
		$result = json_decode($ret, true);

		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));
		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user cannot edit w/o valid announcements.content
 *
 * @return void
 */
	public function testEditContentError() {
		$this->_generateController('Announcements.Announcements');
		RolesControllerTest::login($this);

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'content' => '',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
				'comment' => 'edit comment',
			),
			sprintf('save_%s', NetCommonsBlockComponent::STATUS_PUBLISHED) => '',
		);

		$view = $this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'type' => 'json',
					'return' => 'contents'
				)
			);
		$result = json_decode($view, true);

		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));
		$this->assertArrayHasKey('name', $result, print_r($result, true));
		$this->assertArrayHasKey('error', $result, print_r($result, true));
		$this->assertArrayHasKey('validationErrors', $result['error'], print_r($result, true));
		$this->assertArrayHasKey('content', $result['error']['validationErrors'], print_r($result, true));

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user cannot disapprove publish request from editor w/o comments.comment
 *
 * @return void
 */
	public function testEditCommentError() {
		$this->_generateController('Announcements.Announcements');
		RolesControllerTest::login($this);

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'content' => 'edit content',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
				'comment' => '',
			),
			sprintf('save_%s', NetCommonsBlockComponent::STATUS_DISAPPROVED) => '',
		);

		$view = $this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'type' => 'json',
					'return' => 'contents'
				)
			);
		$result = json_decode($view, true);

		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));
		$this->assertArrayHasKey('name', $result, print_r($result, true));
		$this->assertArrayHasKey('error', $result, print_r($result, true));
		$this->assertArrayHasKey('validationErrors', $result['error'], print_r($result, true));

		AuthGeneralControllerTest::logout($this);
	}
}
