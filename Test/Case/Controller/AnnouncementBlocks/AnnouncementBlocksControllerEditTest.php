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
	protected $_plugin = 'announcements';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'announcement_blocks';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
		'plugin.workflow.comment',
	);

/**
 * add()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testAddPost() {
		$frameId = '6';

		$this->data = array(
			'save_1' => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => null,
				'key' => null,
				'language_id' => '2',
				'room_id' => '2',
				'plugin_key' => $this->_plugin,
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

		parent::testAddPost();
	}

/**
 * add()のPOSTパラメータテスト(ValidationError)
 *
 * @return void
 */
	public function testAddPostValidationError() {
		$frameId = '6';

		$this->data = array(
			'save_1' => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => null,
				'key' => null,
				'language_id' => '2',
				'room_id' => '2',
				'plugin_key' => $this->_plugin,
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
				//'content' => 'Announcement test'
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment test'
			),
		);

		parent::testAddPost();

		$this->assertNotEmpty($this->contents);
	}

/**
 * edit()のPUTパラメータテスト
 *
 * @return void
 */
	public function testEditPut() {
		//アクション実行
		$frameId = '6';
		$blockId = '4';

		$this->data = array(
			'save_1' => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => 'block_3',
				'language_id' => '2',
				'room_id' => '2',
				'plugin_key' => $this->_plugin,
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

		parent::testEditPut();

		$this->assertEmpty($this->contents);
	}

/**
 * edit()のPUTパラメータテスト(ValidationError)
 *
 * @return void
 */
	public function testEditPutValidationError() {
		//アクション実行
		$frameId = '6';
		$blockId = '4';

		$this->data = array(
			'save_1' => null,
			'Frame' => array(
				'id' => $frameId,
			),
			'Block' => array(
				'id' => $blockId,
				'key' => 'block_3',
				'language_id' => '2',
				'room_id' => '2',
				'plugin_key' => $this->_plugin,
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
				//'content' => 'Announcement test'
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment test'
			),
		);

		parent::testEditPut();

		$this->assertNotEmpty($this->contents);
	}

/**
 * delete()のPOSTパラメータテスト
 *
 * @return void
 */
	public function testDeletePost() {
		//アクション実行
		$blockId = '4';

		$this->data = array(
			'Block' => array(
				'id' => $blockId,
				'key' => 'block_3',
			),
			'Announcement' => array(
				'key' => 'announcement_3',
			),
		);

		parent::testDeletePost();
	}

}
