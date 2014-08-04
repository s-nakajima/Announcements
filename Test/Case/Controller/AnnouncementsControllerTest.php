<?php
/**
 * AnnouncementsController Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppController', 'Controller');

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
		'plugin.announcements.Announcement_block_part',
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
		$this->testAction('/announcements/announcements/index', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * postへpost
 *
 * @return   void
 */
	public function testPostForPost() {
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security'
			)
		));
		$this->Controller->isAjax = true;
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
 * delete
 *
 * @return   void
 */
	public function testDelete() {
		$this->testAction('/announcements/announcements/delete/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * get_edit_form
 *
 * @return   void
 */
	public function testGetEditForm() {
		$this->testAction('/announcements/announcements/form/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
		//add
		$this->testAction('/announcements/announcements/add/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * edit error
 *
 * @return   void
 */
	public function testEditPostError() {
		$this->testAction('/announcements/announcements/edit/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * index login
 *
 * @return void
 */
	public function testIndexLogin() {
		//$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		//ログイン状態をつくった。
		$this->createLogind();
		Configure::write('isSetting', true);
		$this->Controller->isEdit = true;
		$this->Controller->isBlockEdit = true;

		//ajaxかどうかの判定をtrueにする。
		//$this->Controller->request->is('ajax');
		$this->testAction('/announcements/announcements/index/2/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
		//$_SERVER['HTTP_X_REQUESTED_WITH'] = false;
	}

/**
 * 非同期通信 id1でログイン
 *
 * @return void
 */
	public function testIndexNoSetting() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		//ログイン状態をつくった。
		$this->createLogind();

		Configure::write('isSetting', false);
		$this->Controller->isEdit = true;
		$this->Controller->isBlockEdit = true;
		$this->testAction('/announcements/announcements/index/2/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
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
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * login状態をつくる
 *
 * @return void
 */
	public function createLogind() {
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
		return $auth;
	}
}
