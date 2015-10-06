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
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - hasEdit: 編集ボタン(リンク)の有無
 *  - return: testActionの実行後の結果
 *  - exception: Exception
 *
 * @return array
 */
	public function dataProviderView() {
		$results = array();

		//ログインなし
		//--コンテンツあり
		$results[0] = array(
			'urlOptions' => array('frame_id' => '6', 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
			'hasEdit' => false
		);
		//--コンテンツなし
		$results[1] = array(
			'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
			'assert' => array('method' => 'assertEquals', 'expected' => 'emptyRender'),
			'hasEdit' => null, 'return' => 'view'
		);

		return $results;
	}

/**
 * viewアクションのテスト(作成権限のみ)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - hasEdit: 編集ボタン(リンク)の有無
 *  - return: testActionの実行後の結果
 *  - exception: Exception
 *
 * @return array
 */
	public function dataProviderViewByCreatable() {
		$results = array();

		//作成権限のみ
		$results[0] = array(
			'urlOptions' => array('frame_id' => '6', 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
			'hasEdit' => false
		);
		//--コンテンツなし
		$results[1] = array(
			'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
			'assert' => array('method' => 'assertEquals', 'expected' => 'emptyRender'),
			'hasEdit' => null, 'return' => 'view'
		);

		return $results;
	}

/**
 * viewアクションのテスト用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - hasEdit: 編集ボタン(リンク)の有無
 *  - return: testActionの実行後の結果
 *  - exception: Exception
 *
 * @return array
 */
	public function dataProviderViewByEditable() {
		$results = array();

		//編集権限あり
		//--コンテンツあり
		$results[0] = array(
			'urlOptions' => array('frame_id' => '6', 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
			'hasEdit' => true
		);
		//--コンテンツなし
		$results[1] = array(
			'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
			'hasEdit' => true
		);
		//フレーム削除テスト
		$results[2] = array(
			'urlOptions' => array('frame_id' => '12', 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
			'hasEdit' => true
		);
		//フレームなしテスト
		$results[3] = array(
			'urlOptions' => array('frame_id' => '999999', 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
			'hasEdit' => true
		);
		//フレームID指定なしテスト
		$results[4] = array(
			'urlOptions' => array('frame_id' => null, 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
			'hasEdit' => true
		);

		return $results;
	}

}
