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

App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('YAControllerTestCase', 'NetCommons.TestSuite');
App::uses('RolesControllerTest', 'Roles.Test/Case/Controller');
App::uses('AuthGeneralControllerTest', 'AuthGeneral.Test/Case/Controller');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class AnnouncementsControllerTestBase extends YAControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		//'plugin.net_commons.site_setting',
		'plugin.announcements.announcement',
		//'plugin.blocks.block',
		//'plugin.blocks.block_role_permission',
		//'plugin.boxes.box',
		'plugin.comments.comment',
		//'plugin.frames.frame',
		//'plugin.boxes.boxes_page',
		//'plugin.containers.container',
		//'plugin.containers.containers_page',
		//'plugin.m17n.language',
		//'plugin.pages.languages_page',
		//'plugin.pages.page',
		//'plugin.public_space.space',
		//'plugin.plugin_manager.plugin',
		//'plugin.plugin_manager.plugins_room',
		//'plugin.roles.default_role_permission',
		//'plugin.rooms.roles_rooms_user',
		//'plugin.rooms.roles_room',
		//'plugin.rooms.room',
		//'plugin.rooms.room_role_permission',
		/* 'plugin.topics.topic', */
		//'plugin.users.user',
		//'plugin.users.user_attributes_user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		YACakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestPlugin');

		Configure::write('Config.language', 'ja');
		$this->generate(
			'Announcements.Announcements',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('Config.language', null);
		CakeSession::write('Auth.User', null);
		parent::tearDown();
	}
}
