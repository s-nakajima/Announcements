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
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerTest extends ControllerTestCase {

/**
 * mock controller object
 *
 * @var null
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
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
				'RequestHandler',
				'NetCommons.NetCommonsBlock', //use Announcement model
				'NetCommons.NetCommonsFrame',
				'NetCommons.NetCommonsRoomRole',
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
 * index for no set frame id
 *
 * @return void
 */
	public function testBeforeFilterForNoSetFrameId() {
		$this->setExpectedException('BadRequestException');
		$this->testAction('/announcements/announcements/index', array('method' => 'get'));
	}

/**
 * index
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));

		$expected = 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.';
		$this->assertTextContains($expected, $this->view);
	}

/**
 * index for no set block id
 *
 * @return void
 */
	public function testIndexForNoSetBlockId() {
		$this->testAction('/announcements/announcements/index/2', array('method' => 'get'));
		$this->assertEmpty(trim($this->view));
	}

/**
 * view
 *
 * @return void
 */
	public function testView() {
		$this->testAction('/announcements/announcements/view/1', array('method' => 'get'));

		$expected = 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.';
		$this->assertTextContains($expected, $this->view);
	}

/**
 * view for no set block id
 *
 * @return void
 */
	public function testViewForNoSetBlockId() {
		$this->testAction('/announcements/announcements/view/2', array('method' => 'get'));
		$this->assertEmpty(trim($this->view));
	}

/**
 * manage for no login
 *
 * @return void
 */
	public function testManageForNoLogin() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/manage/1', array('method' => 'get'));
	}

/**
 * manage for no login
 *
 * @return void
 */
	public function testManageForLogin() {
		$this->login();

		$this->testAction('/announcements/announcements/manage/1', array('method' => 'get'));

		//タブ
		$this->assertTextContains('href="#nc-announcements-edit-1"', $this->view);
		$this->assertTextContains('id="nc-announcements-edit-1"', $this->view);
		$this->assertTextContains('role="tab" data-toggle="tab"', $this->view);
	}
}
