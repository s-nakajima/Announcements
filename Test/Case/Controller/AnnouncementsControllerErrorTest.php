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
 * testEditLoginError method
 *
 * @return void
 */
	public function testEditLoginError() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/edit/1.json', array('method' => 'get'));
	}

/**
 * testContentEditableError method
 *
 * @return void
 */
	public function testContentEditableError() {
		$this->setExpectedException('ForbiddenException');

		$this->_generateController('Announcements.Announcements');
		$this->_loginVisitor();

		$this->testAction('/announcements/announcements/edit/1.json', array('method' => 'get'));

		$this->_logout();
	}

/**
 * testEditStatusError method
 *
 * @return void
 */
	public function testEditStatusError() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginAdmin();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'content' => 'edit content',
			),
			'Comment' => array(
				'comment' => 'edit comment',
			),
			'Frame' => array(
				'id' => '1'
			)
		);

		$view = $this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);

		$result = json_decode($view, true);
		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));

		$this->_logout();
	}

/**
 * testEditContentPublishedError method
 *
 * @return void
 */
	public function testEditContentPublishedError() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginEditor();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'edit content',
			),
			'Comment' => array(
				'comment' => 'edit comment',
			),
			'Frame' => array(
				'id' => '1'
			)
		);

		$view = $this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);
		$result = json_decode($view, true);
		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));

		$this->_logout();
	}

/**
 * testEditContentDisapprovedError method
 *
 * @return void
 */
	public function testEditContentDisapprovedError() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginEditor();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
				'content' => 'edit content',
			),
			'Comment' => array(
				'comment' => 'edit comment',
			),
			'Frame' => array(
				'id' => '1'
			)
		);

		$view = $this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'post',
					'data' => $postData,
					'return' => 'contents'
				)
			);
		$result = json_decode($view, true);
		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));

		$this->_logout();
	}

}
