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
		'app.page',
		'app.block',
		//'app.frame',
		'app.part',
		'app.room_part',
		'app.languages_part',
		'app.language',
		'plugin.announcements.announcement',
		'plugin.announcements.announcement_parts_setting',
		'plugin.announcements.announcements_block',
		'plugin.announcements.announcement_setting',
		'plugin.announcements.announcements_frame',
		'plugin.announcements.announcements_rooms_user',
		'app.box',
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

		//ログアウト
		CakeSession::delete('Auth.User');
		// language ja 存在する
		$this->testAction('/announcements/announcements/view/1/ja', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
	}

/**
 * view content detail setting mode on
 *
 * @return   void
 */
	public function testViewSettingMode() {
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
	public function testViewEditableUserOnSetting() {
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
	public function testForm() {
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
		// frameIdなし viewへそのまま処理を渡しているため、testViewと同じ結果になる。
		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
	}
}
