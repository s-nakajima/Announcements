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
 * active frameId
 *
 * @var int
 */
	const ACTIVE_FRAME_ID = 1;

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
 * edit
 *
 * @return   void
 */
	public function testEditGetError() {
		//get error
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
		$data['Announcement']['frameId'] = self::ACTIVE_FRAME_ID;
		$data['Announcement']['blockId'] = 1;
		$data['Announcement']['status'] = "Draft";
		$data['Announcement']['langId'] = 2;
		$data['Announcement']['id'] = 0;
		$this->testAction('/announcements/announcements/edit/' . self::ACTIVE_FRAME_ID . '/ja',
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
		$data['Announcement']['frameId'] = 100;
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
}
