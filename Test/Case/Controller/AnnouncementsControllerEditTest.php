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
class AnnouncementsControllerEditTest extends ControllerTestCase {

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
 * 存在するblock
 *
 * @var int
 */
	const EXISTING_BLOCK = 1;

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
		'plugin.announcements.box',
		'plugin.announcements.parts_rooms_user',
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
 * edit
 *
 * @return   void
 */
	public function testEditGetError() {
		//getでのアクセスを許可していない
		$this->testAction('/announcements/announcements/edit/1/', array('method' => 'get'));
		$this->assertTextNotContains('Announcement', $this->result);
	}

/**
 * edit post
 *
 * @return   void
 */
	public function testEditPost() {
		//postによる正常処理
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security'
			)
		));
		$data = array();
		$data['Announcement']['content'] = rawurlencode("test"); //URLエンコード
		$data['Announcement']['frameId'] = 1;
		$data['Announcement']['blockId'] = 1;
		$data['Announcement']['status'] = "Draft";
		$data['Announcement']['langId'] = 2;
		$data['Announcement']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/1/',
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextContains('Announcement', $this->result);
	}

/**
 * edit post Permission errors
 *
 * @return   void
 */
	public function testEditPostPermissionError() {
		//postによる正常処理
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security'
			)
		));
		$data = array();
		$data['Announcement']['content'] = rawurlencode("test"); //URLエンコード
		$data['Announcement']['frameId'] = self::EXISTING_FRAME;
		$data['Announcement']['blockId'] = self::EXISTING_BLOCK;
		$data['Announcement']['status'] = "Draft";
		$data['Announcement']['langId'] = 2;
		$data['Announcement']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/' . self::EXISTING_FRAME . '/jpn',
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextNotContains('Announcement', $this->result);
	}

/**
 * edit post Permission errors
 *
 * @return   void
 */
	public function testEditPostParameterError() {
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security'
			)
		));
		//urlのframeIdとpostで渡されたframeIdが違うため失敗する。
		$data = array();
		$data['Announcement']['content'] = rawurlencode("test"); //URLエンコード
		$data['Announcement']['frameId'] = self::NOT_EXISTING_FRAME;
		$data['Announcement']['blockId'] = self::EXISTING_BLOCK;
		$data['Announcement']['status'] = "Draft";
		$data['Announcement']['langId'] = 2;
		$data['Announcement']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/' . self::NOT_EXISTING_FRAME,
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextNotContains('Announcement', $this->result);
	}

/**
 * edit post db errors
 *
 * @return   void
 */
	public function testEditPostDbError() {
		CakeSession::write('Auth.User.id', self::CONTENT_EDITABLE_USER_ID);
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->Controller = $this->generate('Announcements.Announcements', array(
			'components' => array(
				'Security'
			)
		));

		//urlのframeIdとpostで渡されたframeIdが違うため失敗する。
		$data = array();
		$data['Announcement']['content'] = rawurlencode("test"); //URLエンコード
		$data['Announcement']['frameId'] = self::EXISTING_FRAME;
		$data['Announcement']['blockId'] = self::EXISTING_BLOCK;
		$data['Announcement']['status'] = "Draft";
		$data['Announcement']['langId'] = 2;
		$data['Announcement']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/' . (self::EXISTING_FRAME + 1 ),
			array (
				'method' => 'post',
				'data' => $data
			)
		);
		$this->assertTextNotContains('Announcement', $this->result);
	}
}
