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
App::uses('WorkflowControllerViewTest', 'Workflow.TestSuite');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerViewTest extends WorkflowControllerViewTest {

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
 * viewアクションのテスト用DataProvider
 *
 * @return array
 */
	public function dataProviderView() {
		//$role, $urlOptions, $asserts, $hasEdit, $return, $exception
		return array(
			//ログインなし
			//--コンテンツあり
			array(
				'role' => null,
				'urlOptions' => array('frame_id' => '6', 'block_id' => '2', 'key' => null),
				'asserts' => array(
					array('method' => 'assertNotEmpty')
				),
				'hasEdit' => false
			),
			//--コンテンツなし
			array(
				'role' => null,
				'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
				'asserts' => array(
					array('method' => 'assertEquals', 'expected' => 'emptyRender')
				),
				'hasEdit' => null, 'return' => 'view'
			),
			//作成権限のみ
			array(
				'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => '6', 'block_id' => '2', 'key' => null),
				'asserts' => array(
					array('method' => 'assertNotEmpty')
				),
				'hasEdit' => false
			),
			//--コンテンツなし
			array(
				'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
				'asserts' => array(
					array('method' => 'assertEquals', 'expected' => 'emptyRender')
				),
				'hasEdit' => null, 'return' => 'view'
			),
			//編集権限あり
			//--コンテンツあり
			array(
				'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => '6', 'block_id' => '2', 'key' => null),
				'asserts' => array(
					array('method' => 'assertNotEmpty')
				),
				'hasEdit' => true
			),
			//--コンテンツなし
			array(
				'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
				'asserts' => array(
					array('method' => 'assertNotEmpty')
				),
				'hasEdit' => true
			),
			//フレーム削除テスト
			array(
				'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => '12', 'block_id' => '2', 'key' => null),
				'asserts' => array(
					array('method' => 'assertNotEmpty')
				),
				'hasEdit' => true
			),
			//フレームなしテスト
			array(
				'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => '999999', 'block_id' => '2', 'key' => null),
				'asserts' => array(
					array('method' => 'assertNotEmpty')
				),
				'hasEdit' => true
			),
			//フレームID指定なしテスト
			array(
				'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => '2', 'key' => null),
				'asserts' => array(
					array('method' => 'assertNotEmpty')
				),
				'hasEdit' => true
			),
		);
	}

}
