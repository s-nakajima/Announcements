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
App::uses('AnnouncementsAppTest', 'Announcements.Test/Case/Controller');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerErrorTest extends AnnouncementsAppTest {

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

/**
 * testContentEditableError method
 *
 * @return void
 */
	public function testContentEditableError() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/edit/1.json', array('method' => 'get'));
	}

/**
 * testEditStatusError method
 *
 * @return void
 */
	public function testEditStatusError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.Announcements');
		$this->_loginAdmin();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'content' => 'edit content',
				'comment' => 'edit comment',
			),
			'Frame' => array(
				'id' => '1'
			)
		);

		$this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);

		$this->_logout();
	}

/**
 * testEditContentPublishedError method
 *
 * @return void
 */
	public function testEditContentPublishedError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.Announcements');
		$this->_loginEditor();

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

		$this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);

		$this->_logout();
	}

/**
 * testEditContentDisapprovedError method
 *
 * @return void
 */
	public function testEditContentDisapprovedError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.Announcements');
		$this->_loginEditor();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
				'content' => 'edit content',
				'comment' => 'edit comment',
			),
			'Frame' => array(
				'id' => '1'
			)
		);

		$this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);

		$this->_logout();
	}

/**
 * testEditSaveError method
 *
 * @return void
 */
	public function testEditSaveError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.Announcements');
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

		$this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);

		$this->_logout();
	}

}
