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
class AnnouncementEditControllerValidateErrorTest extends AnnouncementsAppControllerTest {

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
 * testEditContentError method
 *
 * @return void
 */
	public function testEditContentError() {
		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginAdmin();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => '',
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

		$expected = array(
			'name' => __d('net_commons', 'Validation errors'),
			'errors' => array(
				'content' => array(
					sprintf(__d('net_commons', 'Please input %s.'), __d('announcements', 'Content'))
				)
			)
		);

		$this->assertEquals($expected, $this->vars['result'],
				'Json data =' . print_r($this->vars['result'], true));

		$this->_logout();
	}

/**
 * testEditCommentError method
 *
 * @return void
 */
	public function testEditCommentError() {
		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginAdmin();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
				'content' => 'edit content',
				'comment' => '',
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

		$expected = array(
			'name' => __d('net_commons', 'Validation errors'),
			'errors' => array(
				'comment' => array(
					sprintf(__d('net_commons', 'Please input %s.'), __d('announcements', 'Comment'))
				)
			)
		);

		$this->assertEquals($expected, $this->vars['result'],
				'Json data =' . print_r($this->vars['result'], true));

		$this->_logout();
	}
}
