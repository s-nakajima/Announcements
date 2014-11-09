<?php
/**
 * AnnouncementEditController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementEditController', 'Announcements.Controller');
App::uses('AnnouncementsAppControllerTest', 'Announcements.Test/Case/Controller');

/**
 * AnnouncementEditController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementEditControllerErrorTest extends AnnouncementsAppControllerTest {

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

		$this->_generateController('Announcements.AnnouncementEdit', array(
			'components' => array('NetCommons.NetCommonsFrame'),
		));
		$this->_setComponentError('NetCommonsFrame', 'setView');

		$this->testAction('/announcements/announcement_edit/index/1.json', array('method' => 'get'));
	}

/**
 * testNCRoomRoleError method
 *
 * @return void
 */
	public function testNCRoomRoleError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.AnnouncementEdit', array(
			'components' => array('NetCommons.NetCommonsRoomRole'),
		));
		$this->_setComponentError('NetCommonsRoomRole', 'setView');

		$this->testAction('/announcements/announcement_edit/index/1.json', array('method' => 'get'));
	}

/**
 * testEditMethodError method
 *
 * @return void
 */
	public function testContentEditableError() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcement_edit/index/1.json', array('method' => 'get'));
	}

/**
 * testEditMethodError method
 *
 * @return void
 */
	public function testEditMethodError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginAdmin();

		$this->testAction('/announcements/announcement_edit/edit/1.json', array('method' => 'get'));

		$this->_logout();
	}

/**
 * testEditSaveError method
 *
 * @return void
 */
	public function testEditSaveError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_setModelError('Announcements.Announcement', 'save');
		$this->_loginAdmin();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'edit content',
				'comment' => 'edit comment',
			),
			'Frame' => array(
				'id' => '1'
			)
		);

		$this->testAction('/announcements/announcement_edit/edit/1.json',
			array(
				'method' => 'post',
				'data' => $postData
			)
		);

		$this->_logout();
	}

}
