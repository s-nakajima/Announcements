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


/**
 * Summary for AnnouncementEditsController Test Case
 */
class AnnouncementsControllerTest extends ControllerTestCase {

/**
 * setUp
 *
 * @return   void
 */
	public function setUp() {
		parent::setUp();
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
		'plugin.announcements.announcement_room'
	);

/**
 * index
 *
 * @return   void
 */
	public function testIndex() {
		// frameIdなし
		$this->testAction('/announcements/announcements/index', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		// frameId指定 デェフォルトの言語
		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		// 言語指定英語 データ無しの場合
		Configure::write('Config.language', 'en');
		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
	}

/**
 * postへpost
 *
 * @return   void
 */
	public function testPostForPost() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security'
			)
		));
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 1;
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
	}

/**
 * postへpost 例外系エラー
 *
 * @return   void
 */
	public function testPostForPostError() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security'
			)
		));

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
		//errorになるはずだからsuccessはこない
		$this->assertTextNotContains('success', $this->result);
	}

/**
 * get_edit_form
 *
 * @return   void
 */
	public function testGetEditForm() {
		$this->testAction('/announcements/announcements/form/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
		//add
		$this->testAction('/announcements/announcements/add/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
	}

/**
 * edit error
 *
 * @return   void
 */
	public function testEditGetError() {
		$this->testAction('/announcements/announcements/edit/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
	}

/**
 * index login
 *
 * @return void
 */
	public function testIndexLogin() {
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

		$this->testAction('/announcements/announcements/index/1/ja', array('method' => 'get'));

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
		//ログイン状態をつくった。
		//$this->createLogind();
		Configure::write('isSetting', false);
		$this->testAction('/announcements/announcements/index/2/ja', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
	}

/**
 *
 * @return void
 */
	public function testIndexNoLogin() {
		//ajax通信ON
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		//ログイン状態をつくった。
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security'
			)
		));
		//ajaxかどうかの判定をtrueにする。
		$this->Controller->request->is('ajax');
		$this->testAction('/announcements/announcements/index/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->result);
	}

/**
 * login状態をつくる
 *
 * @return void
 */
	public function createLogind() {
		/*
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security',
				'Auth' => array('user'),
			)
		));
		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(array($this, 'authUserCallback')));
		$this->Controller->Auth->login(array(
				'username' => 'admin',
				'password' => 'admin',
			)
		);
		$rtn = $this->Controller->Auth->loggedIn();
		$this->assertTrue($rtn);
		*/

		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Auth' => array('user')
			)
		));
		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue(array(
				'id' => 1,
				'username' => 'admin',
				'created' => '2013-05-08 00:00:00',
				'modified' => '2013-05-08 00:00:00',
			)));
		$rtn = $this->Controller->Auth->loggedIn();
		$this->assertTrue($rtn);
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
		$auth = array(
			'id' => 1,
			'username' => 'admin',
		);
		if (empty($key) || !isset($auth[$key])) {
			return $auth;
		}
		return $auth[$key];
	}
}
