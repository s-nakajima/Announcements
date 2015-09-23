<?php
/**
 * AnnouncementsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsController', 'Announcements.Controller');
App::uses('AnnouncementsControllerTestBase', 'Announcements.Test/Case/Controller');

/**
 * AnnouncementsController Error Test Case w/o model based validation errors
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerErrorTest extends AnnouncementsControllerTestBase {

/**
 * Expect unauthenticated user cannot view edit action
 *
 * @return void
 */
	public function testEditLoginError() {
		//$this->setExpectedException('ForbiddenException');
		//$this->testAction('/announcements/announcements/edit/1.json', array('method' => 'get'));
	}

/**
 * Expect visitor cannot view edit action
 *
 * @return void
 */
	public function testContentEditableError() {
		//$this->setExpectedException('ForbiddenException');
		//
		//RolesControllerTest::login($this, Role::ROLE_KEY_VISITOR);
		//
		//$this->testAction('/announcements/announcements/edit/1.json', array('method' => 'get'));
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect editor cannot publish announcement
 *
 * @return void
 */
	public function testEditContentPublishedError() {
		//RolesControllerTest::login($this, Role::ROLE_KEY_EDITOR);
		//
		//$postData = array(
		//	'Announcement' => array(
		//		'block_id' => '1',
		//		'key' => 'announcement_1',
		//		'content' => 'edit content',
		//	),
		//	'Comment' => array(
		//		'comment' => 'edit comment',
		//	),
		//	'Frame' => array(
		//		'id' => '1'
		//	),
		//	sprintf('save_%s', WorkflowComponent::STATUS_PUBLISHED) => '',
		//);
		//
		//$view = $this->testAction(
		//		'/announcements/announcements/edit/1.json',
		//		array(
		//			'method' => 'post',
		//			'type' => 'json',
		//			'data' => $postData,
		//			'return' => 'contents'
		//		)
		//	);
		//
		//$result = json_decode($view, true);
		//$this->assertArrayHasKey('code', $result, print_r($result, true));
		//$this->assertEquals(400, $result['code'], print_r($result, true));
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect editor cannot disapprove announcement
 *
 * @return void
 */
	public function testEditContentDisapprovedError() {
		//RolesControllerTest::login($this, Role::ROLE_KEY_EDITOR);
		//
		//$postData = array(
		//	'Announcement' => array(
		//		'block_id' => '1',
		//		'key' => 'announcement_1',
		//		'content' => 'edit content',
		//	),
		//	'Comment' => array(
		//		'comment' => 'edit comment',
		//	),
		//	'Frame' => array(
		//		'id' => '1'
		//	),
		//	sprintf('save_%s', WorkflowComponent::STATUS_DISAPPROVED) => '',
		//);
		//
		//$view = $this->testAction(
		//		'/announcements/announcements/edit/1.json',
		//		array(
		//			'method' => 'post',
		//			'type' => 'json',
		//			'data' => $postData,
		//			'return' => 'contents'
		//		)
		//	);
		//$result = json_decode($view, true);
		//$this->assertArrayHasKey('code', $result, print_r($result, true));
		//$this->assertEquals(400, $result['code'], print_r($result, true));
		//
		//AuthGeneralControllerTest::logout($this);
	}
}
