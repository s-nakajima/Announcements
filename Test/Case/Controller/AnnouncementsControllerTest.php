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
 * Existing frames.id
 *
 * @var int
 */
	const EXISTING_FRAME = 1;

/**
 * Not existing frames.id
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
		'plugin.announcements.frames_language',
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
		//there is no frameId
		$this->testAction('/announcements/announcements/view', array('method' => 'get'));
		$this->assertTextNotContains('announcement', $this->result);
		$this->assertTextEquals('', $this->result);

		// Correct URL content is displayed
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/eng', array('method' => 'get'));
		$this->assertNotEmpty($this->result);
		$this->assertTextContains('announcement', $this->result);

		// Not Existing frames.id
		$this->testAction('/announcements/announcements/view/' . self::NOT_EXISTING_FRAME, array('method' => 'get'));
		$this->assertEmpty($this->result);

		// Existing frames.id  empty Contents.
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextNotContains('announcement', $this->result);
		$this->assertEmpty($this->result);

		CakeSession::delete('Auth.User.id');
		// Existing frames.id. empty Contents
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextNotContains('announcement', $this->result);
		$this->assertEmpty($this->result);

		//Not logged in.
		CakeSession::delete('Auth.User.id');
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/eng', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextContains('announcement', $this->result);

		//Logged. Existing Contents
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertNotEmpty($this->result);

		//Logged. Not existing Contents
		$this->testAction('/announcements/announcements/view/' . self::NOT_EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertEmpty($this->result);

		//Not logged. Not existing Contents
		CakeSession::delete('Auth.User');
		$this->testAction('/announcements/announcements/view/' . self::EXISTING_FRAME . '/eng', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertTextContains('nc-announcement', $this->result);

		//Not logged. Not existing Contents
		CakeSession::delete('Auth.User');
		$this->testAction('/announcements/announcements/view/' . self::NOT_EXISTING_FRAME . '/eng', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
		$this->assertEmpty($this->result);
	}

/**
 * view content detail setting mode on
 *
 * @return void
 */
	public function testViewSettingMode() {
		//Content exists
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		$this->testAction('/announcements/announcements/view/1/jpn', array('method' => 'get'));
		$this->assertTextContains('announcement', $this->result);

		//Content exists
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		Configure::write('Pages.isSetting', true);
		$this->testAction('/announcements/announcements/view/1/jpn', array('method' => 'get'));
		$this->assertTextContains('Announcement', $this->result);

		//Content does not exist
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
		//Content does not exist
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
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		//Content does not exist
		$this->testAction('/announcements/announcements/form/' . self::EXISTING_FRAME . '/', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
	}

/**
 * index
 *
 * @return   void
 */
	public function testIndex() {
		//same /announcements/announcements/view/
		$this->testAction('/announcements/announcements/index/' . self::NOT_EXISTING_FRAME . '/jpn', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->result);
	}
}
