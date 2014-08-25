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

/**
 * Summary for AnnouncementEditsController Test Case
 */
class AnnouncementsControllerTest extends ControllerTestCase {

/**
 * room admin  users.id
 *
 * @var int
 */
	const ROOM_ADMIN_USER_ID = 1;

/**
 * content editable users.id
 *
 * @var int
 */
	const CONTENT_EDITABLE_USER_ID = 1;

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.session',
		'app.site_setting',
		'app.site_setting_value',
		'plugin.announcements.page',
		'plugin.announcements.block',
		'plugin.announcements.part',
		'plugin.announcements.room_part',
		'plugin.announcements.languages_part',
		'plugin.announcements.language',
		'plugin.announcements.announcement',
		'plugin.announcements.announcement_part_setting',
		'plugin.announcements.announcements_block',
		'plugin.announcements.announcement_setting',
		'plugin.announcements.frame',
		'plugin.announcements.parts_rooms_user',
		'plugin.announcements.box',
	);

/**
 * setUp
 *
 * @return   void
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
		parent::tearDown();
		CakeSession::delete('Auth.User');
		Configure::delete('Pages.isSetting');
	}

/**
 * view content detail
 *
 * @return   void
 */
	public function testView() {
		// frameIdなし
		/*
		$this->testAction('/announcements/announcements/view', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		$this->testAction('/announcements/announcements/view/1', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		// 存在するframeId
		$this->testAction('/announcements/announcements/view/1', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextContains('announcement', $this->result);
		$this->assertNotNull($this->result);

		// 存在しないframeId
		$this->testAction('/announcements/announcements/view/1000000', array('method' => 'get'));
		$this->assertTextEquals('', $this->result);

		// 存在するframeId
		$this->testAction('/announcements/announcements/view/1/', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextContains('announcement', $this->result);

		//未ログイン
		CakeSession::delete('Auth.User.id');
		// language ja 存在する
		$this->testAction('/announcements/announcements/view/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		//ログイン
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		// language ja 存在する
		$this->testAction('/announcements/announcements/view/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		$this->testAction('/announcements/announcements/view/100000/ja', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		//ログインしているidが取得できない状態
		CakeSession::delete('Auth.User');
		// language ja 存在する
		$this->testAction('/announcements/announcements/view/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		*/
	}

/**
 * view content detail setting mode on
 *
 * @return   void
 */
	public function estViewSettingMode() {
		//ログイン
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		// language ja 存在する
		$this->testAction('/announcements/announcements/view/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		//書き込み権限が有り、セッティングモードON
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		Configure::write('Pages.isSetting', true);
		$this->testAction('/announcements/announcements/view/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		//書き込み権限が有り、セッティングモードOFF コンテンツが無い
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		Configure::write('Pages.isSetting', false);
		$this->testAction('/announcements/announcements/view/100000/ja', array('method' => 'get'));
		$this->assertTextNotContains('Announcement', $this->result);
	}

/**
 * view content detail setting mode on
 *
 * @return   void
 */
	public function estViewEditableUserOnSetting() {
		//書き込み権限が有り、セッティングモードON
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		Configure::write('Pages.isSetting', true);
		$this->testAction('/announcements/announcements/view/5/ja', array('method' => 'get'));
		$this->assertTextNotContains('Announcement', $this->result);
	}

/**
 * view content detail setting mode on
 *
 * @return   void
 */
	public function estForm() {
		//ログイン //書き込み権限が有り
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		// language ja 存在する
		$this->testAction('/announcements/announcements/form/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
	}

/**
 * index
 *
 * @return   void
 */
	public function testIndex() {
		$this->assertTrue(true);
		// frameIdなし viewへそのまま処理を渡しているため、testViewと同じ結果になる。
		//$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
		//$this->assertTextNotContains('error', $this->result);
	}
}
