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
class AnnouncementsControllerTest extends AnnouncementsAppTest {

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$view = $this->testAction(
				'/announcements/announcements/index/1',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
		$this->assertTextContains('Lorem ipsum dolor sit amet', $view, print_r($view, true));
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$view = $this->testAction(
				'/announcements/announcements/view/1',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
		$this->assertTextContains('Lorem ipsum dolor sit amet', $view, print_r($view, true));
	}

/**
 * testView method
 *
 * @return void
 */
	public function testViewByAdmin() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginAdmin();

		$view = $this->testAction(
				'/announcements/announcements/view/1',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
		$this->assertTextContains('ng-controller="Announcements"', $view, print_r($view, true));
		$this->assertTextContains('ng-init="initialize(1,', $view, print_r($view, true));
		$this->assertTextContains('ng-click="showSetting()"', $view, print_r($view, true));
		$this->assertTextContains('ng-bind-html="htmlContent()"', $view, print_r($view, true));

		$this->_logout();
	}

/**
 * testViewByNewFrameId method
 *
 * @return void
 */
	public function testViewByNewFrameId() {
		$view = $this->testAction(
				'/announcements/announcements/view/3',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
		$this->assertEmpty($view, $view, print_r($view, true));
	}

/**
 * testView method
 *
 * @return void
 */
	public function testSetting() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginAdmin();

		$view = $this->testAction(
				'/announcements/announcements/setting/1',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);

		$this->assertTextContains('<textarea', $view, print_r($view, true));
		$this->assertTextContains('ui-tinymce="tinymceOptions"', $view, print_r($view, true));
		$this->assertTextContains('ng-model="edit.data.Announcement.content"', $view, print_r($view, true));
		$this->assertTextContains('ng-model="edit.data.Comment.comment"', $view, print_r($view, true));

		$this->assertTextContains('ng-click="cancel()"', $view, print_r($view, true));
		$this->assertTextContains('ng-click="save(AnnouncementForm1, \'3\')"', $view, print_r($view, true));
		$this->assertTextContains('ng-click="save(AnnouncementForm1, \'1\')"', $view, print_r($view, true));

		$this->_logout();
	}

/**
 * testToken method
 *
 * @return void
 */
	public function testToken() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginAdmin();

		$view = $this->testAction(
				'/announcements/announcements/token/1.json',
				array(
					'method' => 'get',
					'return' => 'vars',
				)
			);

		$this->assertArrayHasKey('announcement', $view, print_r($view, true));
		$this->assertArrayHasKey('Announcement', $view['announcement'], print_r($view, true));
		$this->assertArrayHasKey('id', $view['announcement']['Announcement'], print_r($view, true));
		$this->assertEquals('announcement_1', $view['announcement']['Announcement']['key'], print_r($view, true));

		$this->_logout();
	}

/**
 * testFormEditor method
 *
 * @return void
 */
	public function testTokenByEditor() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginEditor();

		$view = $this->testAction(
				'/announcements/announcements/token/1.json',
				array(
					'method' => 'get',
					'return' => 'vars',
				)
			);

		$this->assertArrayHasKey('announcement', $view, print_r($view, true));
		$this->assertArrayHasKey('Announcement', $view['announcement'], print_r($view, true));
		$this->assertArrayHasKey('id', $view['announcement']['Announcement'], print_r($view, true));
		$this->assertEquals('announcement_1', $view['announcement']['Announcement']['key'], print_r($view, true));

		$this->_logout();
	}

/**
 * testEditPost method
 *
 * @return void
 */
	public function testEditGet() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginAdmin();

		$view = $this->testAction(
				'/announcements/announcements/edit/1.json',
				array(
					'method' => 'get',
					'return' => 'contents'
				)
			);
		$result = json_decode($view, true);

		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(200, $result['code'], print_r($result, true));
		$this->assertArrayHasKey('name', $result, print_r($result, true));
		$this->assertArrayHasKey('results', $result, print_r($result, true));
		$this->assertArrayHasKey('announcement', $result['results'], print_r($result, true));
		$this->assertArrayHasKey('Announcement', $result['results']['announcement'], print_r($result, true));
		$this->assertArrayHasKey('comments', $result['results'], print_r($result, true));

		$this->_logout();
	}

/**
 * testEditPost method
 *
 * @return void
 */
	public function testEditPost() {
		$this->_generateController('Announcements.Announcements');
		$this->_loginAdmin();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'edit content',
			),
			'Frame' => array(
				'id' => '1'
			),
			'Comment' => array(
				'plugin_key' => 'announcements',
				'content_key' => 'announcement_1',
				'comment' => 'edit comment',
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
		$this->assertEquals(200, $result['code'], print_r($result, true));
		$this->assertArrayHasKey('name', $result, print_r($result, true));
		$this->assertArrayHasKey('results', $result, print_r($result, true));
		$this->assertArrayHasKey('announcement', $result['results'], print_r($result, true));
		$this->assertArrayHasKey('Announcement', $result['results']['announcement'], print_r($result, true));

		$this->_logout();
	}

}
