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
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class ViewTest extends AnnouncementsControllerTestBase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->generate('Announcements.Announcements', array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
			)
		));
	}

/**
 * Expect visitor can access view action
 *
 * @return void
 */
	public function testView() {
		//$this->testAction(
		//	'/announcements/announcements/view/1',
		//	array(
		//		'method' => 'get',
		//		'return' => 'view',
		//	)
		//);
		//$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect visitor can access view action by json
 *
 * @return void
 */
	public function testViewJson() {
		//$this->testAction(
		//	'/announcements/announcements/view/1.json',
		//	array(
		//		'method' => 'get',
		//		'type' => 'json',
		//		//'return' => 'contents',
		//	)
		//);
		//
		//$this->assertTextEquals('view', $this->controller->view);
		//$this->assertTextEquals('ajax', $this->controller->layout);
	}

/**
 * Expect admin user can access view action
 *
 * @return void
 */
	public function testViewByAdmin() {
		//RolesControllerTest::login($this);
		//
		//$view = $this->testAction(
		//	'/announcements/announcements/view/1',
		//	array(
		//		'method' => 'get',
		//		'return' => 'view',
		//	)
		//);
		//
		//$this->assertTextContains('/announcements/announcements/edit/1', $view, print_r($view, true));
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user cannot access view action with unknown frame id
 *
 * @return void
 */
	public function testViewByUnkownFrameId() {
		//$this->setExpectedException('InternalErrorException');
		//$this->testAction(
		//	'/announcements/announcements/view/999',
		//	array(
		//		'method' => 'get',
		//		'return' => 'view',
		//	)
		//);
	}

/**
 * Expect admin user can access edit action
 *
 * @return void
 */
	public function testEditGet() {
		//RolesControllerTest::login($this);
		//
		//$this->testAction(
		//	'/announcements/announcements/edit/1',
		//	array(
		//		'method' => 'get',
		//		'return' => 'contents'
		//	)
		//);
		//
		//$this->assertTextEquals('edit', $this->controller->view);
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect view action to be successfully handled w/ null frame.block_id
 * This situation typically occur after placing new plugin into page
 *
 * @return void
 */
	public function testAddFrameWithoutBlock() {
		//$this->testAction(
		//	'/announcements/announcements/view/3',
		//	array(
		//		'method' => 'get',
		//		'return' => 'contents'
		//	)
		//);
		//$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect admin user can publish announcements
 *
 * @return void
 */
	public function testEditPost() {
		//RolesControllerTest::login($this);
		//
		//$data = array(
		//	'Announcement' => array(
		//		'block_id' => '1',
		//		'key' => 'announcement_1',
		//		'content' => 'edit content',
		//	),
		//	'Frame' => array(
		//		'id' => '1'
		//	),
		//	'Comment' => array(
		//		'comment' => 'edit comment',
		//	),
		//	sprintf('save_%s', WorkflowComponent::STATUS_PUBLISHED) => '',
		//);
		//
		//$this->testAction(
		//	'/announcements/announcements/edit/1',
		//	array(
		//		'method' => 'post',
		//		'data' => $data,
		//		'return' => 'contents'
		//	)
		//);
		//$this->assertTextEquals('edit', $this->controller->view);
		//
		//AuthGeneralControllerTest::logout($this);
	}
}
