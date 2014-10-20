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

App::uses('AnnouncementsController', 'Announcements.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerTest extends ControllerTestCase {

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
		'plugin.frames.box',
		'plugin.frames.language',
		'plugin.announcements.frame',
		'plugin.announcements.plugin',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.user',
	);

/**
 * setUp
 *
 * @return void
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
	}

/**
 * testBeforeFilterByNoSetFrameId method
 *
 * @return void
 */
	public function testBeforeFilterByNoSetFrameId() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/index', array('method' => 'get'));
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));

		$expected = 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.';
		$this->assertTextContains($expected, $this->view);
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$this->testAction('/announcements/announcements/view/1', array('method' => 'get'));

		$expected = 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.';
		$this->assertTextContains($expected, $this->view);
	}

/**
 * testViewByNoSetBlockId method
 *
 * @return void
 */
	public function testViewByNoSetBlockId() {
		$this->testAction('/announcements/announcements/view/2', array('method' => 'get'));
		$this->assertEmpty(trim($this->view));
	}
}
