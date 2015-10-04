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
App::uses('AnnouncementsControllerAllTestBase', 'Announcements.Test/Case/Controller');
App::uses('WorkflowContentEditPostTest', 'Workflow.TestSuite');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerEditPostTest extends AnnouncementsControllerAllTestBase implements WorkflowContentEditPostTest {

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
	protected $_action = 'edit';

/**
 * $this->dataに値をセットする
 *
 * @param array $params Set data
 * @return void
 */
	private function __setData($params) {
		$this->data = array(
			'Frame' => array(
				'id' => $params['frameId']
			),
			'Block' => array(
				'id' => $params['blockId'],
				'key' => $params['blockKey'],
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => $this->plugin,
			),
			'Announcement' => array(
				'id' => $params['anouncementId'],
				'key' => $params['anouncementKey'],
				'block_id' => $params['blockId'],
				'language_id' => '2',
				'status' => null,
				'content' => 'Announcement test'
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment test'
			),
		);
	}

/**
 * edit()のPUT(POST)パラメータのテスト(ログインなし)
 *
 * @return void
 */
	public function testEditPost() {
		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';
		$anouncementId = '2';
		$anouncementKey = 'announcement_1';

		$this->__setData(array(
			'frameId' => $frameId,
			'blockId' => $blockId,
			'blockKey' => $blockKey,
			'anouncementId' => $anouncementId,
			'anouncementKey' => $anouncementKey,
		));
		$this->data['save_' . WorkflowComponent::STATUS_IN_DRAFT] = null;

		//アクション実行
		$this->setExpectedException('ForbiddenException');
		$this->_testNcAction(
			array(
				'action' => 'edit',
				'frame_id' => $frameId,
			)
		);
	}

/**
 * edit()のPUT(POST)パラメータのテスト(作成権限あり)
 *
 * @return void
 */
	public function testEditPostByCreatable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testEditPost();

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のPUT(POST)パラメータのテスト(編集権限あり)
 *
 * @return void
 */
	public function testEditPostByEditable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_EDITOR);

		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';
		$anouncementId = '2';
		$anouncementKey = 'announcement_1';

		$this->__setData(array(
			'frameId' => $frameId,
			'blockId' => $blockId,
			'blockKey' => $blockKey,
			'anouncementId' => $anouncementId,
			'anouncementKey' => $anouncementKey,
		));
		$this->data['save_' . WorkflowComponent::STATUS_APPROVED] = null;

		//アクション実行
		$this->_testNcAction(
			array(
				'action' => 'edit',
				'frame_id' => $frameId,
			)
		);

		//評価
		$this->assertEmpty($this->contents); //redirectしているため、空になる
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のPUT(POST)パラメータのテスト(公開権限あり)
 *
 * @return void
 */
	public function testEditPostByPublishable() {
		AuthGeneralTestSuite::login($this);

		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';
		$anouncementId = '2';
		$anouncementKey = 'announcement_1';

		$this->__setData(array(
			'frameId' => $frameId,
			'blockId' => $blockId,
			'blockKey' => $blockKey,
			'anouncementId' => $anouncementId,
			'anouncementKey' => $anouncementKey,
		));
		$this->data['save_' . WorkflowComponent::STATUS_PUBLISHED] = null;

		//アクション実行
		$this->_testNcAction(
			array(
				'action' => 'edit',
				'frame_id' => $frameId,
			)
		);

		//評価
		$this->assertEmpty($this->contents); //redirectしているため、空になる
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のPUT(POST)パラメータのValidationErrorテスト
 *
 * @return void
 */
	public function testEditPostValidationError() {
		AuthGeneralTestSuite::login($this);

		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';
		$anouncementId = '2';
		$anouncementKey = 'announcement_1';

		$this->__setData(array(
			'frameId' => $frameId,
			'blockId' => $blockId,
			'blockKey' => $blockKey,
			'anouncementId' => $anouncementId,
			'anouncementKey' => $anouncementKey,
		));
		$this->data['save_' . WorkflowComponent::STATUS_PUBLISHED] = null;
		unset($this->data['Announcement']['content']);

		//アクション実行
		$this->_testNcAction(
			array(
				'action' => 'edit',
				'frame_id' => $frameId,
			)
		);

		//評価
		$this->assertNotEmpty($this->contents);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralTestSuite::logout($this);
	}

}
