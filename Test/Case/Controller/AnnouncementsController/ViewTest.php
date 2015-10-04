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
App::uses('AnnouncementsControllerTestAllBase', 'Announcements.Test/Case/Controller');
App::uses('WorkflowContentViewTest', 'Workflow.TestSuite');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerViewTest extends AnnouncementsControllerAllTestBase implements WorkflowContentViewTest {

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'announcements';

/**
 * Action name
 *
 * @var string
 */
	protected $_action = 'view';

/**
 * view()のテスト(ログインなし)
 *
 * @return void
 */
	public function testView() {
		//アクション実行
		$frameId = '6';
		$blockId = '2';
		$this->_testNcAction(
			array('frame_id' => $frameId, 'block_id' => $blockId)
		);

		//評価
		$this->assertNotEmpty($this->contents);
		$editUrl = $this->_getActionUrl(array(
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$this->assertTextNotContains($editUrl, $this->contents);
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
		$blockId = '2';
		$this->_testNcAction(
			array('frame_id' => $frameId, 'block_id' => $blockId)
		);

		//評価
		$this->assertNotEmpty($this->contents);
		$editUrl = $this->_getActionUrl(array(
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$this->assertTextContains($editUrl, $this->contents);

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
		$this->_testNcAction(
			array('frame_id' => $frameId)
		);

		//評価
		$this->assertEmpty($this->contents);
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
		$this->_testNcAction(
			array('frame_id' => $frameId)
		);

		//評価
		$this->assertNotEmpty($this->contents);
		$editUrl = $this->_getActionUrl(array(
			'action' => 'edit',
			'frame_id' => $frameId,
		));
		$this->assertTextContains($editUrl, $this->contents);

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
		$blockId = '2';
		$this->_testNcAction(
			array('frame_id' => $frameId, 'block_id' => $blockId)
		);

		//評価
		$this->assertNotEmpty($this->contents);
		$editUrl = $this->_getActionUrl(array(
			'action' => 'edit',
			'frame_id' => $frameId,
			'block_id' => $blockId
		));
		$this->assertTextNotContains($editUrl, $this->contents);
	}

}
