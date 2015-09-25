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
App::uses('AnnouncementsControllerTestBase', 'Announcements.Test/Case/Controller');
App::uses('WorkflowContentViewTest', 'Workflow.TestSuite');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class ViewTest extends AnnouncementsControllerTestBase implements WorkflowContentViewTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->generate('Announcements.Announcements', array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
			)
		));
	}

/**
 * view()のテスト(ログインなし)
 *
 * @return void
 */
	public function testView() {
		//アクション実行
		$frameId = '6';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => 'announcements',
			'controller' => 'announcements',
			'action' => 'view',
			'frame_id' => $frameId,
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		//評価
		$this->assertNotEmpty($result);
		$editUrl = NetCommonsUrl::actionUrl(array(
			'plugin' => 'announcements',
			'controller' => 'announcements',
			'action' => 'edit',
			'frame_id' => $frameId,
		));
		$this->assertTextNotContains($editUrl, $result);
	}

/**
 * view()のテスト(作成権限あり)
 *
 * @return void
 */
	public function testViewByCreatable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testView();

		AuthGeneralTestSuite::logout($this);
	}

/**
 * view()のテスト(編集権限あり)
 *
 * @return void
 */
	public function testViewByEditable() {
		AuthGeneralTestSuite::login($this);

		//アクション実行
		$frameId = '6';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => 'announcements',
			'controller' => 'announcements',
			'action' => 'view',
			'frame_id' => $frameId,
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		//評価
		$this->assertNotEmpty($result);
		$editUrl = NetCommonsUrl::actionUrl(array(
			'plugin' => 'announcements',
			'controller' => 'announcements',
			'action' => 'edit',
			'frame_id' => $frameId,
		));
		$this->assertTextContains($editUrl, $result);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * view()のコンテンツなしテスト
 *
 * @return void
 */
	public function testViewNoContent() {
		//アクション実行
		$frameId = '14';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => 'announcements',
			'controller' => 'announcements',
			'action' => 'view',
			'frame_id' => $frameId,
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		//評価
		$this->assertEmpty($result);
	}

/**
 * view()のコンテンツなしテスト(編集権限あり)
 *
 * @return void
 */
	public function testViewNoContentByEditable() {
		AuthGeneralTestSuite::login($this);

		//アクション実行
		$frameId = '14';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => 'announcements',
			'controller' => 'announcements',
			'action' => 'view',
			'frame_id' => $frameId,
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		//評価
		$this->assertNotEmpty($result);
		$editUrl = NetCommonsUrl::actionUrl(array(
			'plugin' => 'announcements',
			'controller' => 'announcements',
			'action' => 'edit',
			'frame_id' => $frameId,
		));
		$this->assertTextContains($editUrl, $result);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * view()のフレーム削除テスト
 *
 * @return void
 */
	public function testViewOnDeleteFrame() {
		//アクション実行
		$frameId = '12';
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => 'announcements',
			'controller' => 'announcements',
			'action' => 'view',
			'frame_id' => $frameId,
		));
		$result = $this->testAction($url, array(
			'method' => 'get',
			'return' => 'view',
		));

		//評価
		$this->assertNotEmpty($result);
		$editUrl = NetCommonsUrl::actionUrl(array(
			'plugin' => 'announcements',
			'controller' => 'announcements',
			'action' => 'edit',
			'frame_id' => $frameId,
		));
		$this->assertTextNotContains($editUrl, $result);
	}


}
