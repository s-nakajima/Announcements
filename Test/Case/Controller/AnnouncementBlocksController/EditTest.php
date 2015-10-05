<?php
/**
 * AnnouncementBlocksController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementBlocksController', 'Announcements.Controller');
App::uses('BlocksControllerEditTest', 'Blocks.TestSuite');

/**
 * AnnouncementBlocksController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementBlocksControllerEditTest extends BlocksControllerEditTest {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'announcements';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
		'plugin.workflow.workflow_comment',
	);

/**
 * add()アクションDataProvider
 *
 * @return void
 */
	public function dataProviderByAdd() {
		$frameId = '6';

		$default = array(
			'save_1' => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => null,
				'key' => null,
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => $this->plugin,
				'public_type' => '1',
				'from' => null,
				'to' => null,
			),
			'Announcement' => array(
				'id' => null,
				'key' => null,
				'block_id' => null,
				'language_id' => '2',
				'status' => null,
				'content' => 'Announcement test'
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment test'
			),
		);

		$data = array();
		$data[0] = array('method' => 'get');
		$data[1] = array('method' => 'put');
		$data[2] = array('method' => 'post', 'data' => $default, 'validationError' => false);
		$data[3] = array('method' => 'post', 'data' => $default, 'validationError' => true);
		unset($data[3]['data']['Announcement']['content']);

		return $data;
	}

/**
 * edit()アクションDataProvider
 *
 * @return void
 */
	public function dataProviderByEdit() {
		$frameId = '6';
		$blockId = '4';

		$default = array(
			'save_1' => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => 'block_3',
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => $this->plugin,
				'public_type' => '1',
				'from' => null,
				'to' => null,
			),
			'Announcement' => array(
				'id' => '4',
				'key' => 'announcement_3',
				'block_id' => $blockId,
				'language_id' => '2',
				'status' => '2',
				'content' => 'Announcement test'
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment test'
			),
		);

		$data = array();
		$data[0] = array('method' => 'get');
		$data[1] = array('method' => 'post');
		$data[2] = array('method' => 'put', 'data' => $default, 'validationError' => false);
		$data[3] = array('method' => 'put', 'data' => $default, 'validationError' => true);
		unset($data[3]['data']['Announcement']['content']);

		return $data;
	}

/**
 * delete()アクションDataProvider
 *
 * @return void
 */
	public function dataProviderByDelete() {
		$blockId = '4';

		$default = array(
			'Block' => array(
				'id' => $blockId,
				'key' => 'block_3',
			),
			'Announcement' => array(
				'key' => 'announcement_3',
			),
		);

		$data = array(
			array('data' => $default)
		);
		return $data;
	}

}
