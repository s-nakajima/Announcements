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
App::uses('WorkflowControllerEditTest', 'Workflow.TestSuite');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerEditTest extends WorkflowControllerEditTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
		'plugin.announcements.workflow_comment4announcements',
	);

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'announcements';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'announcements';

/**
 * editアクションのGETテスト用DataProvider
 *
 * @return array
 */
	public function dataProviderEditGet() {
		//$role, $urlOptions, $asserts, $hasDelete, $exception
		$frameId = '6';
		$blockId = '2';
		$anouncementId = '2';
		$anouncementKey = 'announcement_1';
		$asserts = array(
			0 => array('method' => 'assertNotEmpty'),
			1 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Frame][id]', 'value' => $frameId),
			2 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Block][id]', 'value' => $blockId),
			3 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Announcement][id]', 'value' => $anouncementId),
			4 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Announcement][key]', 'value' => $anouncementKey),
			5 => array('method' => 'assertInput', 'type' => 'textarea', 'name' => 'data[Announcement][content]', 'value' => null),
			6 => array('method' => 'assertInput', 'type' => 'button', 'name' => 'save_' . WorkflowComponent::STATUS_IN_DRAFT, 'value' => null),
			7 => array('method' => 'assertInput', 'type' => 'button', 'name' => 'save_' . WorkflowComponent::STATUS_PUBLISHED, 'value' => null),
		);

		return array(
			//ログインなし
			array(
				'role' => null,
				'urlOptions' => array('frame_id' => $frameId, 'block_id' => $blockId, 'key' => $anouncementKey),
				'asserts' => null, 'hasDelete' => null, 'exception' => 'ForbiddenException'
			),
			//作成権限のみ
			array(
				'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $frameId, 'block_id' => $blockId, 'key' => $anouncementKey),
				'asserts' => null, 'hasDelete' => null, 'exception' => 'ForbiddenException'
			),
			//編集権限あり
			//--コンテンツあり
			array(
				'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => $frameId, 'block_id' => $blockId, 'key' => $anouncementKey),
				'asserts' => Hash::merge($asserts, array(
					7 => array('method' => 'assertInput', 'type' => 'button', 'name' => 'save_' . WorkflowComponent::STATUS_APPROVED, 'value' => null),
				)),
				'hasDelete' => null
			),
			//--コンテンツなし
			array(
				'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
				'asserts' => Hash::merge($asserts, array(
					1 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Frame][id]', 'value' => null),
					2 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Block][id]', 'value' => null),
					3 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Announcement][id]', 'value' => null),
					4 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Announcement][key]', 'value' => null),
					7 => array('method' => 'assertInput', 'type' => 'button', 'name' => 'save_' . WorkflowComponent::STATUS_APPROVED, 'value' => null),
				)),
				'hasDelete' => null
			),
			//フレーム削除テスト
			array(
				'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => '12', 'block_id' => $blockId, 'key' => $anouncementKey),
				'asserts' => Hash::merge($asserts, array(
					1 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Frame][id]', 'value' => '12'),
				)),
				'hasDelete' => null
			),
			//フレームなしテスト
			array(
				'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => '999999', 'block_id' => $blockId, 'key' => $anouncementKey),
				'asserts' => Hash::merge($asserts, array(
					1 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Frame][id]', 'value' => null),
				)),
				'hasDelete' => null
			),
			//フレームID指定なしテスト
			array(
				'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => $blockId, 'key' => $anouncementKey),
				'asserts' => Hash::merge($asserts, array(
					1 => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Frame][id]', 'value' => null),
				)),
				'hasDelete' => null
			),
		);
	}

/**
 * editアクションのPOSTテスト用DataProvider
 *
 * @return array
 */
	public function dataProviderEditPost() {
		//$data, $role, $urlOptions, $exception

		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';
		$anouncementId = '2';
		$anouncementKey = 'announcement_1';

		$data = array(
			'save_' . WorkflowComponent::STATUS_IN_DRAFT => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => $blockKey,
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => $this->plugin,
			),
			'Announcement' => array(
				'id' => $anouncementId,
				'key' => $anouncementKey,
				'block_id' => $blockId,
				'language_id' => '2',
				'status' => null,
				'content' => 'Announcement save test'
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment save test'
			),
		);

		return array(
			//ログインなし
			array(
				'data' => $data, 'role' => null,
				'urlOptions' => array('frame_id' => $frameId, 'block_id' => $blockId, 'key' => $anouncementKey),
				'exception' => 'ForbiddenException'
			),
			//作成権限のみ
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $frameId, 'block_id' => $blockId, 'key' => $anouncementKey),
				'exception' => 'ForbiddenException'
			),
			//編集権限あり
			//--コンテンツあり
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => $frameId, 'block_id' => $blockId, 'key' => $anouncementKey),
			),
			//--コンテンツなし
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
			),
			//フレーム削除テスト
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => '12', 'block_id' => $blockId, 'key' => $anouncementKey),
			),
			//フレームなしテスト
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => '999999', 'block_id' => $blockId, 'key' => $anouncementKey),
			),
			//フレームID指定なしテスト
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => $blockId, 'key' => $anouncementKey),
			),
		);
	}

/**
 * editアクションのValidationErrorテスト用DataProvider
 *
 * @return array
 */
	public function dataProviderEditValidationError() {
		//$data, $role, $urlOptions, $validationError

		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';
		$anouncementId = '2';
		$anouncementKey = 'announcement_1';

		$data = array(
			'save_' . WorkflowComponent::STATUS_IN_DRAFT => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => $blockKey,
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => $this->plugin,
			),
			'Announcement' => array(
				'id' => $anouncementId,
				'key' => $anouncementKey,
				'block_id' => $blockId,
				'language_id' => '2',
				'status' => null,
				'content' => 'Announcement save test'
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment save test'
			),
		);

		return array(
			//バリデーションエラー
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => $frameId, 'block_id' => $blockId, 'key' => $anouncementKey),
				'validationError' => array(
					'field' => 'Announcement.content',
					'value' => '',
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('announcements', 'Content'))
				)
			),
		);
	}

}
