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
App::uses('AnnouncementsAppControllerTest', 'Announcements.Test/Case/Controller');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerErrorTest extends AnnouncementsAppControllerTest {

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
 * testNCFrameError method
 *
 * @return void
 */
	public function testNCFrameError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.Announcements', array(
			'components' => array('NetCommons.NetCommonsFrame'),
		));
		$this->_setComponentError('NetCommonsFrame', 'setView');

		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
	}

/**
 * testNCRoomRoleError method
 *
 * @return void
 */
	public function testNCRoomRoleError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.Announcements', array(
			'components' => array('NetCommons.NetCommonsRoomRole'),
		));
		$this->_setComponentError('NetCommonsRoomRole', 'setView');

		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
	}
}
