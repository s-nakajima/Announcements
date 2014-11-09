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

App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsAppControllerTest extends ControllerTestCase {

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
		'plugin.frames.page',
		'plugin.frames.box',
		'plugin.frames.language',
		'plugin.announcements.user_attributes_user',
		'plugin.announcements.user',
		'plugin.announcements.frame',
		'plugin.announcements.plugin',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('Config.language', null);
		unset($this->Controller);
		parent::tearDown();
	}

/**
 * _generateController method
 *
 * @param string $controllerName controller name
 * @param array $addMocks generate options
 * @return void
 */
	protected function _generateController($controllerName, $addMocks = array()) {
		$mocks = array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
				//'RequestHandler',
			)
		);
		$params = array_merge_recursive($mocks, $addMocks);

		$this->Controller = $this->generate($controllerName, $params);
	}

/**
 * _loginAdmin method
 *
 * @return void
 */
	protected function _loginAdmin() {
		//ログイン処理
		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(
					function() {
						$array = array(
							'id' => 1,
							'username' => 'admin',
							'role_key' => 'system_administrator',
						);
						CakeSession::write('Auth.User', $array);
						return $array;
					}
				));

		$this->Controller->Auth->login(array(
				'username' => 'admin',
				'password' => 'admin',
			)
		);
		$this->assertTrue($this->Controller->Auth->loggedIn(), '_loginAdmin');
	}

/**
 * _loginAdmin method
 *
 * @return void
 */
	protected function _loginEditor() {
		//ログイン処理
		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(
					function() {
						$array = array(
							'id' => 3,
							'username' => 'editor',
							'role_key' => 'editor',
						);
						CakeSession::write('Auth.User', $array);
						return $array;
					}
				));

		$this->Controller->Auth->login(array(
				'username' => 'editor',
				'password' => 'editor',
			)
		);
		$this->assertTrue($this->Controller->Auth->loggedIn(), '_loginEditor');
	}

/**
 * _logout method
 *
 * @return void
 */
	protected function _logout() {
		//ログアウト処理
		$this->testAction('/auth/logout', array(
			'data' => array(
			),
		));
		$this->assertEqual($this->headers['Location'], Router::url('/auth/login', true));
		$this->assertNull(CakeSession::read('Auth.User'), '_logout');
	}

/**
 * _setComponentError method
 *
 * @param string $componentName component name
 * @param string $methodName method name
 * @return void
 */
	protected function _setComponentError($componentName, $methodName) {
		$this->Controller->$componentName
			->staticExpects($this->any())
			->method($methodName)
			->will($this->returnValue(false));

		$this->assertTrue(
				method_exists($this->Controller->$componentName, $methodName),
				get_class($this->Controller->$componentName) . '::' . $methodName
			);
	}

/**
 * _setModelError method
 *
 * @param string $modelName model name
 * @param string $methodName method name
 * @return void
 */
	protected function _setModelError($modelName, $methodName) {
		$this->Controller->$modelName = $this->getMockForModel($modelName, array($methodName));
		$this->Controller->$modelName->expects($this->any())
			->method($methodName)
			->will($this->returnValue(false));

		$this->assertTrue(
				method_exists($this->Controller->$modelName, $methodName),
				get_class($this->Controller->$modelName) . '::' . $methodName
			);
	}

/**
 * _assertGetAnnouncement method
 *
 * @param array $expected correct data
 * @param array $result result data
 * @return void
 */
	protected function _assertAnnouncement($expected, $result) {
		$unsets = array(
			//'created_user',
			'created',
			//'modified_user',
			'modified'
		);

		//Announcementデータのテスト
		foreach ($unsets as $key) {
			if (array_key_exists($key, $result['Announcement'])) {
				unset($result['Announcement'][$key]);
			}
		}

		$this->assertArrayHasKey('Announcement', $result, 'Error ArrayHasKey Announcement');
		$this->assertEquals($expected['Announcement'], $result['Announcement'], 'Error Equals Announcement');

		//Blockデータのテスト
		if (isset($expected['Block'])) {
			foreach ($unsets as $key) {
				if (array_key_exists($key, $result['Block'])) {
					unset($result['Block'][$key]);
				}
			}

			$this->assertArrayHasKey('Block', $result, 'Error ArrayHasKey Block');
			$this->assertEquals($expected['Block'], $result['Block'], 'Error Equals Block');
		}

		//Blockデータのテスト
		if (isset($expected['Block'])) {
			foreach ($unsets as $key) {
				if (array_key_exists($key, $result['Block'])) {
					unset($result['Block'][$key]);
				}
			}

			$this->assertArrayHasKey('Block', $result, 'Error ArrayHasKey Block');
			$this->assertEquals($expected['Block'], $result['Block'], 'Error Equals Block');
		}
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}
}
