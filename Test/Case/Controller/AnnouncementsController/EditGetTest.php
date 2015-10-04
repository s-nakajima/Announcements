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
App::uses('WorkflowContentEditGetTest', 'Workflow.TestSuite');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerEditGetTest extends AnnouncementsControllerAllTestBase implements WorkflowContentEditGetTest {

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
	protected $_controller = 'announcements';

/**
 * Action name
 *
 * @var string
 */
	protected $_action = 'edit';

/**
 * edit()のGETパラメータのテスト(ログインなし)
 *
 * @return void
 */
	public function testEditGet() {
		$this->setExpectedException('ForbiddenException');

		//アクション実行
		$frameId = '6';
		$this->_testNcAction(
			array('frame_id' => $frameId),
			array('method' => 'get')
		);
	}

/**
 * edit()のGETパラメータのテスト(作成権限あり)
 *
 * @return void
 */
	public function testEditGetByCreatable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		$this->testEditGet();

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のGETパラメータのテスト(編集権限あり)
 *
 * @return void
 */
	public function testEditGetByEditable() {
		AuthGeneralTestSuite::login($this, Role::ROOM_ROLE_KEY_EDITOR);

		$frameId = '6';
		$blockId = '2';
		$anouncementId = '2';
		$anouncementKey = 'announcement_1';

		//アクション実行
		$url = $this->_getActionUrl(
			array('frame_id' => $frameId)
		);
		$this->_testNcAction($url, array('method' => 'get'));

		//評価
		$this->assertRegExp('/<form.*?action=".*?' . preg_quote($url, '/') . '.*?">/', $this->contents);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Frame][id]', '/') . '".*?value="' . $frameId . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Block][id]', '/') . '".*?value="' . $blockId . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Announcement][id]', '/') . '".*?value="' . $anouncementId . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Announcement][key]', '/') . '".*?value="' . $anouncementKey . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<textarea.*?name="' . preg_quote('data[Announcement][content]', '/') . '".*?>.*?<\/textarea>/', $this->contents
		);
		$this->assertRegExp('/<button.*?name="save_' . WorkflowComponent::STATUS_IN_DRAFT . '".*?type="submit".*?>/', $this->contents);
		$this->assertRegExp('/<button.*?name="save_' . WorkflowComponent::STATUS_APPROVED . '".*?type="submit".*?>/', $this->contents);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のGETパラメータのテスト(公開権限あり)
 *
 * @return void
 */
	public function testEditGetByPublishable() {
		AuthGeneralTestSuite::login($this);

		$frameId = '6';
		$blockId = '2';
		$anouncementId = '2';
		$anouncementKey = 'announcement_1';

		//アクション実行
		$url = $this->_getActionUrl(
			array('frame_id' => $frameId)
		);
		$this->_testNcAction($url, array('method' => 'get'));

		//評価
		$this->assertRegExp('/<form.*?action=".*?' . preg_quote($url, '/') . '.*?">/', $this->contents);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Frame][id]', '/') . '".*?value="' . $frameId . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Block][id]', '/') . '".*?value="' . $blockId . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Announcement][id]', '/') . '".*?value="' . $anouncementId . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Announcement][key]', '/') . '".*?value="' . $anouncementKey . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<textarea.*?name="' . preg_quote('data[Announcement][content]', '/') . '".*?>.*?<\/textarea>/', $this->contents
		);
		$this->assertRegExp('/<button.*?name="save_' . WorkflowComponent::STATUS_IN_DRAFT . '".*?type="submit".*?>/', $this->contents);
		$this->assertRegExp('/<button.*?name="save_' . WorkflowComponent::STATUS_PUBLISHED . '".*?type="submit".*?>/', $this->contents);

		AuthGeneralTestSuite::logout($this);
	}

/**
 * edit()のGETパラメータのブロックなしテスト
 *
 * @return void
 */
	public function testEditGetFrameWOBlockId() {
		AuthGeneralTestSuite::login($this);

		$frameId = '14';

		//アクション実行
		$url = $this->_getActionUrl(
			array('frame_id' => $frameId)
		);
		$this->_testNcAction($url, array('method' => 'get'));

		//評価
		$this->assertRegExp('/<form.*?action=".*?' . preg_quote($url, '/') . '.*?">/', $this->contents);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Frame][id]', '/') . '".*?value="' . $frameId . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Block][id]', '/') . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Announcement][id]', '/') . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<input.*?name="' . preg_quote('data[Announcement][key]', '/') . '".*?>/', $this->contents
		);
		$this->assertRegExp(
			'/<textarea.*?name="' . preg_quote('data[Announcement][content]', '/') . '".*?>.*?<\/textarea>/', $this->contents
		);
		$this->assertRegExp('/<button.*?name="save_' . WorkflowComponent::STATUS_IN_DRAFT . '".*?type="submit".*?>/', $this->contents);
		$this->assertRegExp('/<button.*?name="save_' . WorkflowComponent::STATUS_PUBLISHED . '".*?type="submit".*?>/', $this->contents);

		AuthGeneralTestSuite::logout($this);
	}

}
