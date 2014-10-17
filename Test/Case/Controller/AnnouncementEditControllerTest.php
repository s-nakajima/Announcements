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

App::uses('Language', 'app.Model');
App::uses('AnnouncementsController', 'Announcements.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementEditControllerTest extends ControllerTestCase {

/**
 * mock controller object
 *
 * @var Controller
 */
	public $Controller = null;

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'site_setting',
		'plugin.announcements.announcement',
		'plugin.announcements.block',
		'plugin.frames.box',
		'plugin.frames.language',
		'plugin.announcements.frame',
		'plugin.announcements.plugin',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.user',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		if ($this->Controller) {
			$this->Controller->Auth->logout();
			unset($this->Controller);
			CakeSession::write('Auth.User.id', null);
		}

		parent::tearDown();
	}

/**
 * login
 *
 * @return void
 */
	public function login() {
		//ログイン処理
		$this->Controller = $this->generate('Announcements.AnnouncementEdit', array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
				'RequestHandler',
			),
		));

		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(array($this, 'userCallback')));

		$this->Controller->Auth->login(array(
				'username' => 'admin',
				'password' => 'admin',
			)
		);
		CakeSession::write('Auth.User.id', 1);

		$this->assertTrue($this->Controller->Auth->loggedIn(), 'login');
	}

/**
 * authUserCallback
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return array user
 */
	public function userCallback() {
		$user = array(
			'id' => 1,
			'username' => 'admin',
			'role_key' => 'system_administrator',
		);
		return $user;
	}

/**
 * BeforeFilter error for no editable
 *
 * @return void
 */
	public function testBeforeFilterErrorForNoEditable() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcement_edit/index/1', array('method' => 'get'));
	}

/**
 * index for login
 *
 * @return void
 */
	public function testIndexForLogin() {
		$this->login();
		$this->testAction('/announcements/announcement_edit/index/1', array('method' => 'get'));

		//お知らせ編集
		$this->assertTextContains('<textarea', $this->view);
		$this->assertTextContains('ui-tinymce="tinymceOptions"', $this->view);
		$this->assertTextContains('ng-model="announcement.Announcement.content"', $this->view);

		$this->assertTextContains('ng-click="cancel()"', $this->view);
		$this->assertTextContains('ng-click="save(3)"', $this->view);
		$this->assertTextContains('ng-click="save(1)"', $this->view);
	}

/**
 * view for login
 *
 * @return void
 */
	public function testViewForLogin() {
		$this->login();
		$this->testAction('/announcements/announcement_edit/view/1', array('method' => 'get'));

		//お知らせ編集
		$this->assertTextContains('<textarea', $this->view);
		$this->assertTextContains('ui-tinymce="tinymceOptions"', $this->view);
		$this->assertTextContains('ng-model="announcement.Announcement.content"', $this->view);

		$this->assertTextContains('ng-click="cancel()"', $this->view);
		$this->assertTextContains('ng-click="save(3)"', $this->view);
		$this->assertTextContains('ng-click="save(1)"', $this->view);
	}

/**
 * form for login
 *
 * @return void
 */
	public function testFormForLogin() {
		$this->login();
		$this->testAction('/announcements/announcement_edit/form/1', array('method' => 'get'));

		//登録前のForm取得
		$this->assertTextContains('<form action="', $this->view);
		$this->assertTextContains('/announcements/announcement_edit/form/1', $this->view);
		$this->assertTextContains('name="data[Announcement][content]"', $this->view);
		$this->assertTextContains('type="hidden" name="data[Frame][frame_id]"', $this->view);
		$this->assertTextContains('type="hidden" name="data[Announcement][block_id]"', $this->view);
		$this->assertTextContains('select name="data[Announcement][status]"', $this->view);
		$this->assertTextContains('type="hidden" name="data[Announcement][key]"', $this->view);
	}

/**
 * form for login
 *
 * @return void
 */
	public function testPostForRequestGet() {
		$this->login();

		$this->setExpectedException('MethodNotAllowedException');
		$this->testAction('/announcements/announcement_edit/post/1', array('method' => 'get'));
	}

/**
 * form for login
 *
 * @return void
 */
	public function testPostForLogin() {
		$this->login();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'change data',
			),
			'Frame' => array(
				'frame_id' => '1'
			)
		);

		$this->testAction('/announcements/announcement_edit/post/1.json',
			array(
				'method' => 'post',
				'data' => $postData
			)
		);

		$this->assertEquals('result', $this->vars['_serialize']);
		$this->assertEquals(array('message' => 'Success saved.'), $this->vars['result']);
	}

/**
 * form for login
 *
 * @return void
 */
	public function testPostForError() {
		$this->login();

		$postData = array(
			'Announcement' => array(
				'block_id' => null,
				'key' => 'announcement_1',
				'status' => '5',
				'content' => 'change data',
			),
			'Frame' => array(
				'frame_id' => '1'
			)
		);

		$this->setExpectedException('BadRequestException');
		$result = $this->testAction('/announcements/announcement_edit/post/1.json',
			array(
				'method' => 'post',
				'data' => $postData
			)
		);
	}
}
