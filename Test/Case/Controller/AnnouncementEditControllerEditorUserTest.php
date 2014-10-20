<?php
/**
 * AnnouncementEditControllerLoginUser Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsController', 'Announcements.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * AnnouncementEditControllerLoginUser Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementEditControllerEditorUserTest extends ControllerTestCase {

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
		$this->login();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		$this->logout();
		parent::tearDown();
	}

/**
 * login　method
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
			->will($this->returnCallback(array($this, 'authUserCallback')));

		$this->Controller->Auth->login(array(
				'username' => 'editor',
				'password' => 'editor',
				'role_key' => 'editor',
			)
		);
		$this->assertTrue($this->Controller->Auth->loggedIn(), 'login');
	}

/**
 * logout method
 *
 * @return void
 */
	public function logout() {
		//ログアウト処理
		$this->Controller->Auth->logout();
		$this->assertFalse($this->Controller->Auth->loggedIn(), 'logout');

		CakeSession::write('Auth.User', null);
		unset($this->Controller);
	}

/**
 * authUserCallback method
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return array user
 */
	public function authUserCallback() {
		$user = array(
			'id' => 3,
			'username' => 'editor',
			'role_key' => 'editor',
		);
		CakeSession::write('Auth.User', $user);
		return $user;
	}

/**
 * testForm method
 *
 * @return void
 */
	public function testForm() {
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
}
