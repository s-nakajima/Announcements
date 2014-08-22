<?php
/**
 * AnnouncementsController Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppController', 'Controller');
App::uses('AuthGeneralController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('AnnouncementsApp', 'Announcements.Controller');
App::uses('Announcements', 'Announcements.Controller');
App::uses('AnnouncementBlockPart', 'Announcements.Model');
App::uses('NetCommonsFrame', 'NetCommons.Model');

/**
 * Summary for AnnouncementEditsController Test Case
 */
class AnnouncementsControllerTest extends ControllerTestCase {

/**
 * login flag
 *
 * @var bool
 */
	private $__isLogin = false;

/**
 * test user
 *
 * @var array
 */
	private $__user = 1;

/**
 * setUp
 *
 * @return   void
 */
	public function setUp() {
		parent::setUp();
		$this->createLogIn(false);
		$this->BlockPart = ClassRegistry::init('Announcements.AnnouncementBlockPart');
		$this->NetCommonsFrame = ClassRegistry::init('NetCommons.NetCommonsFrame');

		$type = "edit";
		$userId = 1;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		$rtn = $this->BlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertTextEquals(5, count($rtn));
		$data = array(
			'frame_id' => 1,
			'block_id' => 2,
			'part_id' => "2,3,4"
		);

		$rtn = $this->BlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertTextEquals(5, count($rtn));
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlockPart);
		parent::tearDown();
	}

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.Session',
		'app.SiteSetting',
		'app.SiteSettingValue',
		'app.Page',
		'plugin.announcements.announcement_datum',
		'plugin.announcements.announcement',
		'plugin.announcements.announcement_frame',
		'plugin.announcements.announcement_block_part',
		'plugin.announcements.announcement_parts_rooms_user',
		'app.room_part',
		'app.languages_part',
		'plugin.announcements.announcement_room',
		'plugin.announcements.announcement_block_block'
	);

/**
 * index
 *
 * @return   void
 */
	public function testIndex() {
		// frameIdなし
		$this->createLogIn(true, 1);
		$this->testAction('/announcements/announcements/index', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		// frameId指定 デェフォルトの言語
		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		// 言語指定英語 データ無しの場合
		Configure::write('Config.language', 'en');
		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
		//$this->assertTextEquals('', $this->result);
		$this->testAction('/announcements/announcements/index/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		Configure::write('Config.language', 'ja');
		$this->testAction('/announcements/announcements/index/1000000', array('method' => 'get'));
		//$this->assertTextEquals('', $this->result);

		Configure::write('Config.language', 'en');
		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
		//$this->assertTextEquals('', $this->result);
	}

/**
 * postへpost
 *
 * @return   void
 */
	public function testEditForPost() {
		$this->createLogIn(true, 1);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security'
			)
		));
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 1;
		$data['AnnouncementDatum']['blockId'] = 1;
		$data['AnnouncementDatum']['type'] = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/1/',
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextNotContains('ERROR', $this->view);

		$this->createLogIn(true, 1);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 300;
		$data['AnnouncementDatum']['blockId'] = 0;
		$data['AnnouncementDatum']['type'] = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/1/',
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextNotContains('ERROR', $this->view);

		$this->createLogIn(true, 1);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 1;
		$data['AnnouncementDatum']['blockId'] = 1;
		$data['AnnouncementDatum']['type'] = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/1/',
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * postへpost 例外系エラー
 *
 * @return   void
 */
	public function testPostForPostError() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->createLogIn(true, 1);
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 1;
		$data['AnnouncementDatum']['blockId'] = 0;
		$data['AnnouncementDatum']['type'] = "Draft";
		//バリデーションエラーを発生させる設定 本来は数字
		$data['AnnouncementDatum']['langId'] = "test";
		$data['AnnouncementDatum']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/1/',
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextNotContains('success', $this->result);

		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->createLogIn(true, 9);
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 9;
		$data['AnnouncementDatum']['blockId'] = 9;
		$data['AnnouncementDatum']['type'] = "Draft";
		//バリデーションエラーを発生させる設定 本来は数字
		$data['AnnouncementDatum']['langId'] = "test";
		$data['AnnouncementDatum']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/1/',
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextNotContains('success', $this->result);

		$this->assertTextNotContains('success', $this->result);

		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->createLogIn(true, 9);
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 9;
		$data['AnnouncementDatum']['blockId'] = 9;
		$data['AnnouncementDatum']['type'] = "Draft";
		//バリデーションエラーを発生させる設定 本来は数字
		$data['AnnouncementDatum']['langId'] = "test";
		$data['AnnouncementDatum']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/9/',
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextContains('message', $this->result);
	}

/**
 * get_edit_form
 *
 * @return   void
 */
	public function testGetEditForm() {
		$this->createLogIn(true);
		$this->testAction('/announcements/announcements/form/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);

		$this->createLogIn(true, 1);
		$this->testAction('/announcements/announcements/edit/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
	}

/**
 * index login
 *
 * @return void
 */
	public function testIndexLogin() {
		$this->createLogIn(true, 1);
		Configure::write('Pages.isSetting', true);
		$this->testAction('/announcements/announcements/index/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = false;

		$this->createLogIn(true, 1);
		Configure::write('Pages.isSetting', false);
		$this->testAction('/announcements/announcements/index/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = false;

		$this->createLogIn(true, 1);
		Configure::write('Pages.isSetting', true);
		$this->testAction('/announcements/announcements/index/1/en', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = false;

		$this->createLogIn(true, 1);
		Configure::write('Pages.isSetting', false);
		$this->testAction('/announcements/announcements/index/1/en', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = false;
	}

/**
 * 非同期通信 id1でログイン
 *
 * @return void
 */
	public function testIndexNoSetting() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->createLogIn(true, 1);
		//データ有り
		Configure::write('Pages.isSetting', false);
		$this->testAction('/announcements/announcements/index/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
		//データなし
		Configure::write('Pages.isSetting', false);
		$this->testAction('/announcements/announcements/index/100000000000000/ja', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
	}

/**
 *
 * @return void
 */
	public function testIndexNoLogin() {
		$this->createLogIn(false);
		$this->testAction('/announcements/announcements/index/1/ja', array('method' => 'get'));
		$this->assertTrue(is_string($this->result));
		$this->testAction('/announcements/announcements/index/50000000/ja', array('method' => 'get'));
		$this->assertTextEquals('', $this->result);

		$this->createLogIn(true);
		$this->testAction('/announcements/announcements/index/1/', array('method' => 'get'));
		$this->assertTrue(is_string($this->result));
		$this->testAction('/announcements/announcements/index/50000000/', array('method' => 'get'));
		$this->assertTextEquals('', $this->result);
	}

/**
 * login状態をつくる
 *
 * @return void
 */
	public function createLogIn($isLogin, $userId = 1) {
		$this->__isLogin = $isLogin;
		$this->__user = $userId;
		$this->AuthGeneralController = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
			),
		));
		$this->controller->plugin = 'Announcements';
		$this->controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(array($this, 'authUserCallback')));
	}

/**
 * authUserCallback
 *
 * @param type $key
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   mixed
 */
	public function authUserCallback() {
		$auth = $this->__user;
		//ログイン状態を返す
		if ($this->__isLogin) {
			return $auth;
		}
		return null;
	}
}
