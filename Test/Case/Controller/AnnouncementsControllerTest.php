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
 * コンテンツの存在するframe
 *
 * @var int
 */
	const EXISTING_FRAME = 1;

/**
 * 存在しないframe
 *
 * @var int
 */
	const NOT_EXISTING_FRAME = 1000000;

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
		'plugin.announcements.plugin',
		'plugin.announcements.room',
		'plugin.announcements.user',
	);

/**
 * setUp
 *
 * @return   void
 */
	public function setUp() {
		parent::setUp();
		CakeSession::delete('Auth.User');
		Configure::delete('Pages.isSetting');
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
		//frameIdが指定されていない
		$this->testAction('/announcements/announcements/view', array('method' => 'get'));
		$this->assertTextNotContains('announcement', $this->result);
		$this->assertTextEquals('', $this->result);

		// コンテンツが存在するframeId
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/eng', array('method' => 'get'));
		$this->assertTextContains('announcement', $this->result);
		$this->assertNotNull($this->result);

		// 存在しないframeId
		$this->testAction('/announcements/announcements/view/' . self::NOT_EXISTING_FRAME, array('method' => 'get'));
		$this->assertTextEquals('', $this->result);

		// 存在するframeId しかしjpnのコンテンツは無い。
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextNotContains('announcement', $this->result);
		$this->assertTextEquals('', $this->result);

		//未ログイン
		CakeSession::delete('Auth.User.id');
		// 存在するframeId しかしjpnのコンテンツは無い。
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextNotContains('announcement', $this->result);
		$this->assertTextEquals('', $this->result);

		//未ログイン
		CakeSession::delete('Auth.User.id');
		// 存在するframeId 英語コンテンツはあり。
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/eng', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextContains('announcement', $this->result);

		//ログイン
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		// language jpn コンテンツが存在しない
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		$this->testAction('/announcements/announcements/view/' . self::NOT_EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		//ログアウトしている状態
		CakeSession::delete('Auth.User');
		// language コンテンツあり
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/eng', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);

		//ログアウトしている状態
		CakeSession::delete('Auth.User');
		// コンテンツは存在しない
		$this->testAction('/announcements/announcements/view/' . self::NOT_EXISTING_FRAME . '/eng', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextEquals('', $this->result);
	}

/**
 * view content detail setting mode on
 *
 * @return void
 */
	public function testViewSettingMode() {
		//ログインしている // language jpn 存在する
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		$this->testAction('/announcements/announcements/view/1/jpn', array('method' => 'get'));
		$this->assertTextContains('announcement', $this->result);

		//書き込み権限が有り、セッティングモードON コンテンツあり
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		Configure::write('Pages.isSetting', true);
		$this->testAction('/announcements/announcements/view/1/jpn', array('method' => 'get'));
		$this->assertTextContains('Announcement', $this->result);

		//書き込み権限が有り、セッティングモードOFF コンテンツが無い
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		Configure::write('Pages.isSetting', false);
		$this->testAction('/announcements/announcements/view/' . self::NOT_EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('Announcement', $this->result);
	}

/**
 * view content detail setting mode on
 *
 * @return void
 */
	public function testViewEditableUserOnSetting() {
		//書き込み権限が有り、セッティングモードON
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		Configure::write('Pages.isSetting', true);
		$this->testAction('/announcements/announcements/view/5/jpn', array('method' => 'get'));
		$this->assertTextContains('Announcement', $this->result);
	}

/**
 * view content detail setting mode on
 *
 * @return void
 */
	public function testForm() {
		//ログイン 書き込み権限が有りフレームが存在している。
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		//language 日本語 コンテンツ存在しない
		$this->testAction('/announcements/announcements/form/' . self::EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
	}

/**
 * index
 *
 * @return   void
 */
	public function testIndex() {
		//frameIdなし viewへそのまま処理を渡しているため、testViewと同じ結果になる。
		//未ログイン 存在しないframeId コンテンツなし
		$this->testAction('/announcements/announcements/index/' . self::NOT_EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
	}
}
