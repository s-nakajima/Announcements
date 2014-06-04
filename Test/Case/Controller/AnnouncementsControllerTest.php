<?php
/**
 * AnnouncementsController Test Case
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsController', 'Announcements.Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('Block', 'Model');

/**
 * Summary for AnnouncementsController Test Case
 */
class AnnouncementsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'site_setting',
		'site_setting_value',
		'plugin.announcements.block',
		'plugin.announcements.blocks_language',
		'plugin.announcements.language',
		'plugin.announcements.frame',
		'plugin.announcements.parts_rooms_user',
		'plugin.announcements.part',
		'plugin.announcements.room_part',
		'plugin.announcements.announcement',
		'plugin.announcements.announcement_revision',
		'plugin.announcements.announcement_block',
		'plugin.announcements.announcement_blocks_part'
	);

/**
 * Test Input Data
 *
 * @var array
 */
	private $__true = 1;

	private $__false = 0;

	private $__editInputNoneExistData = array();

	private $__editInputData = array();

	private $__blockSettingInputNoneExistData = array();

	private $__blockSettingInputData = array();

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Block = ClassRegistry::init('Block');
		$this->Announcement = ClassRegistry::init('Announcements.Announcement');
		$this->AnnouncementBlock = ClassRegistry::init('Announcements.AnnouncementBlock');
		$this->AnnouncementBlocksPart = ClassRegistry::init('Announcements.AnnouncementBlocksPart');

		$this->__setInputNoneExistData();
		$this->__setInputData();
		$this->__setBlockSettingInputNoneExistData();
		$this->__setBlockSettingInputData();
	}

/**
 * Set input data
 *
 * @return void
 */
	private function __setInputNoneExistData() {
		$this->__editInputNoneExistData = array(
			'Announcement' => array(
				'id' => 0,
				'block_id' => 2,
				'is_published' => $this->__true,
			),
			'AnnouncementRevision' => array(
				'id' => 0,
				'content' => 'Update!',
			),
		);
	}

/**
 * Set input data
 *
 * @return void
 */
	private function __setInputData() {
		$this->__editInputData = array(
			'Announcement' => array(
				'id' => 10,
				'block_id' => 1,
				'is_published' => $this->__false,
			),
			'AnnouncementRevision' => array(
				'id' => 1,
				'content' => 'Update!',
			),
		);
	}

/**
 * Set input data
 *
 * @return void
 */
	private function __setBlockSettingInputNoneExistData() {
		$this->__blockSettingInputNoneExistData = array(
			'AnnouncementBlock' => array(
				'id' => 0,
				'block_id' => 2,
				'send_mail' => 0,
				'mail_subject' => 'Mail Subject',
				'mail_body' => 'Mail Body'
			),
			'AnnouncementBlocksPart' => array(
				array(
					'id' => 0,
					'announcement_block_id' => 0,
					'part_id' => 1,
					'can_edit_content' => $this->__true,
					'can_publish_content' => $this->__true,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 0,
					'announcement_block_id' => 0,
					'part_id' => 2,
					'can_edit_content' => $this->__true,
					'can_publish_content' => $this->__true,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 0,
					'announcement_block_id' => 0,
					'part_id' => 3,
					'can_edit_content' => $this->__false,
					'can_publish_content' => $this->__false,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => '0',
					'announcement_block_id' => 0,
					'part_id' => 4,
					'can_edit_content' => $this->__false,
					'can_publish_content' => $this->__false,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => '0',
					'announcement_block_id' => 0,
					'part_id' => 5,
					'can_edit_content' => $this->__false,
					'can_publish_content' => $this->__false,
					'can_send_mail' => $this->__false,
				)
			),
			'BlocksLanguage' => array(
				'name' => 'Test Block',
			),
		);
	}

/**
 * Set input data
 *
 * @return void
 */
	private function __setBlockSettingInputData() {
		$this->__blockSettingInputData = array(
			'AnnouncementBlock' => array(
				'id' => 10,
				'block_id' => 1,
				'send_mail' => $this->__false,
				'mail_subject' => 'Mail Subject2',
				'mail_body' => 'Mail Body2'
			),
			'AnnouncementBlocksPart' => array(
				array(
					'id' => 10,
					'announcement_block_id' => 10,
					'part_id' => 1,
					'can_edit_content' => $this->__true,
					'can_publish_content' => $this->__true,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 11,
					'announcement_block_id' => 10,
					'part_id' => 2,
					'can_edit_content' => $this->__true,
					'can_publish_content' => $this->__true,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 12,
					'announcement_block_id' => 10,
					'part_id' => 3,
					'can_edit_content' => $this->__false,
					'can_publish_content' => $this->__false,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 13,
					'announcement_block_id' => 10,
					'part_id' => 4,
					'can_edit_content' => $this->__false,
					'can_publish_content' => $this->__false,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 14,
					'announcement_block_id' => 10,
					'part_id' => 5,
					'can_edit_content' => $this->__false,
					'can_publish_content' => $this->__false,
					'can_send_mail' => $this->__false,
				)
			),
			'BlocksLanguage' => array(
				'name' => 'Test Block',
			),
		);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Block);
		unset($this->Announcement);
		unset($this->AnnouncementBlock);
		unset($this->AnnouncementBlocksPart);
		parent::tearDown();
	}

/**
 * mockAuthUser
 * @param integer $userId 1 ルーム管理者 2 編集長 3 編集者 4 一般 5 参観者
 * @param array $addParam
 * @return void
 */
	public function mockAuthUser($userId = 1, $addParam = array()) {
		$params = array_merge(array(
			'components' => array(
				'Auth' => array('user')
			)), $addParam
		);
		$this->Controller = $this->generate('Announcements.Announcements', $params);
		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue(array(
				'id' => $userId,
				//'username' => 'admin'
			)));
	}

/**
 * testIndexNotFoundFrame method
 * Frameが存在しない場合のエラーチェック
 *
 * @return void
 */
	public function testIndexNotFoundFrame() {
		// 存在しないframe_idを指定
		$this->setExpectedException('NotFoundException');
		$this->testAction('/announcements/announcements/index/10', array('method' => 'get'));
	}

/**
 * testIndexNotFoundNoneFrame method
 * Frameを指定しない場合のエラーチェック
 *
 * @return void
 */
	public function testIndexNotFoundNoneFrame() {
		// frame_id指定なし
		$this->setExpectedException('NotFoundException');
		$this->testAction('/announcements/announcements/index', array('method' => 'get'));
	}

/**
 * testIndexForbiddenBlock method
 * Blockに編集権限がない場合のエラーチェック
 *
 * @return void
 */
	public function testIndexForbiddenBlock() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/edit/1', array('method' => 'get'));
	}

/**
 * testIndexForbiddenNotExistsUser method
 * 存在がしない会員の場合のエラーチェック
 *
 * @return void
 */
	public function testIndexForbiddenNotExistsUser() {
		$this->mockAuthUser(5);
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/edit/1', array('method' => 'get'));
	}

/**
 * testEditNotFoundNoneFrame method
 * Frameを指定しない場合のエラーチェック
 *
 * @return void
 */
	public function testEditNotFoundNoneFrame() {
		// frame_id指定なし
		$this->setExpectedException('NotFoundException');
		$this->testAction('/announcements/announcements/edit', array('method' => 'get'));
	}

/**
 * testEditForbiddenBlock method
 * Blockに編集権限がない場合のエラーチェック
 *
 * @return void
 */
	public function testEditForbiddenBlock() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/edit/1', array('method' => 'get'));
	}

/**
 * testEditForbiddenNotExistsUser method
 * 存在がしない会員の場合のエラーチェック
 *
 * @return void
 */
	public function testEditForbiddenNotExistsUser() {
		$this->mockAuthUser(5);
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/edit/1', array('method' => 'get'));
	}

/**
 * testEditGetWithoutAuth method 編集権限なし
 *
 * @return void
 */
	public function testEditGetWithoutAuth() {
		$this->mockAuthUser(4);
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/edit/1', array('method' => 'get'));
	}

/**
 * testBlockSettingNotFoundNoneFrame method
 * Blockを指定しない場合のエラーチェック
 *
 * @return void
 */
	public function testBlockSettingNotFoundNoneBlock() {
		// block_id指定なし
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/block_setting', array('method' => 'get'));
	}

/**
 * testBlockSettingForbiddenBlock method
 * Blockに編集権限がない場合のエラーチェック
 *
 * @return void
 */
	public function testBlockSettingForbiddenBlock() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/block_setting/1', array('method' => 'get'));
	}

/**
 * testBlockSettingForbiddenNotExistsUser method
 * 存在がしない会員の場合のエラーチェック
 *
 * @return void
 */
	public function testBlockSettingForbiddenNotExistsUser() {
		$this->mockAuthUser(5);
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/block_setting/1', array('method' => 'get'));
	}

/**
 * testBlockSettingGetWithoutAuth method 編集権限なし
 *
 * @return void
 */
	public function testBlockSettingGetWithoutAuth() {
		$this->mockAuthUser(4);
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/announcements/announcements/block_setting/1', array('method' => 'get'));
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		// 存在しないAnnouncement.block_idを指定
		$result = $this->testAction('/announcements/announcements/index/2', array('method' => 'get'));
		$this->assertTextContains(__('Content not found.'), $result);

		// 存在するAnnouncement.block_idを指定
		$result = $this->testAction('/announcements/announcements/index/1', array('method' => 'get'));
		$this->assertTextContains('Test1', $result);
	}

/**
 * testIndexAddBlock method
 * Frameデータは存在するが、blockIDが取得できなければ、Blockデータを作成。
 *
 * @return void
 */
	public function testIndexAddBlock() {
		$this->testAction('/announcements/announcements/index/5', array('method' => 'get'));
		$result = $this->Block->findById(5);
		$this->assertTrue(is_array($result));
		$this->assertTrue(is_array($result['Block']));
		$this->assertTrue(is_array($result['Language']));
	}

/**
 * testIndexAddBlockSaveError method
 * Blockデータを作成時のsaveエラー
 *
 * @return void
 */
	public function testIndexAddBlockSaveError() {
		$params = array(
			'models' => array(
				'Block' => array('addBlock')
			)
		);
		$this->Controller = $this->generate('Announcements.AnnouncementsApp', $params);
		$this->Controller->Block->expects($this->once())->method('addBlock')->will($this->returnValue(false));

		$this->setExpectedException('InternalErrorException');
		$this->testAction('/announcements/announcements/index/5', array('method' => 'get'));
	}

/**
 * testIndexAddBlockSaveFieldError method
 * Blockデータを作成後のFrame.block_id更新時エラー
 *
 * @return void
 */
	public function testIndexFrameSaveFieldError() {
		$params = array(
			'models' => array(
				'Frame' => array('saveField')
			)
		);
		$this->Controller = $this->generate('Announcements.AnnouncementsApp', $params);
		$this->Controller->Frame->expects($this->once())->method('saveField')->will($this->returnValue(false));

		$this->setExpectedException('InternalErrorException');
		$this->testAction('/announcements/announcements/index/5', array('method' => 'get'));
	}

/**
 * testEdit method 表示
 *
 * @return void
 */
	public function testEditGet() {
		// 存在しないAnnouncement.block_idを指定
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';	// ajaxリクエストへ
		$this->mockAuthUser(1);
		$result = $this->testAction('/announcements/announcements/edit/2', array('method' => 'get'));
		$this->assertRegExp('/<form/', $result);
		$this->assertRegExp('/><\/textarea>/', $result);

		// 存在するAnnouncement.block_idを指定
		$this->mockAuthUser(1);
		$result = $this->testAction('/announcements/announcements/edit/1', array('method' => 'get'));
		$this->assertTextContains('Test1', $result);
		$this->assertRegExp('/<form/', $result);
		$this->assertRegExp('/>Test1<\/textarea>/', $result);
	}

/**
 * testEditPostNotExists method 登録
 * 存在しないAnnouncement.frame_idを指定
 *
 * @return void
 */
	public function testEditPostNotExists() {
		$this->mockAuthUser(1);
		Configure::load('Revision.config');
		$statusId = Configure::read('Revision.status_id');
		$content = 'Update!';
		// 登録
		$this->testAction(
			'/announcements/announcements/edit/2',
			array('data' => $this->__editInputNoneExistData, 'method' => 'post')
		);
		$this->assertContains('/announcements/announcements/index/2', $this->headers['Location']);

		$results = $this->Announcement->findByBlockId(2);
		$this->assertEquals($results['AnnouncementRevision']['content'], $content);
		$this->assertEquals($results['AnnouncementRevision']['status_id'], $statusId['published']);
	}

/**
 * testEditPostExists method 登録
 * 存在するAnnouncement.frame_idを指定
 *
 * @return void
 */
	public function testEditPostExists() {
		$this->mockAuthUser(1);
		Configure::load('Revision.config');
		$statusId = Configure::read('Revision.status_id');
		$content = 'Update!';
		// 登録
		$this->testAction(
			'/announcements/announcements/edit/1',
			array('data' => $this->__editInputData, 'method' => 'put')
		);
		$this->assertContains('/announcements/announcements/index/1', $this->headers['Location']);

		$results = $this->Announcement->findByBlockId(1);
		$this->assertEquals($results['AnnouncementRevision']['content'], $content);
		$this->assertEquals($results['AnnouncementRevision']['status_id'], $statusId['draft']);
	}

/**
 * testEditPostValidationError method 登録 ValidationError
 *
 * @return void
 */
	public function testEditPostValidationError() {
		$this->mockAuthUser(1);
		// 登録
		$data = $this->__editInputNoneExistData;
		$data['AnnouncementRevision']['content'] = '';

		$this->testAction(
			'/announcements/announcements/edit/1',
			array('data' => $data, 'method' => 'post')
		);
		$results = $this->Announcement->findByBlockId(1);
		$this->assertEquals($results['AnnouncementRevision']['content'], 'Test1');	// 変更されていないことの確認
	}

/**
 * testEditPostSaveError method 登録
 * save Error
 *
 * @return void
 */
	public function testEditPostSaveError() {
		$this->mockAuthUser(1, array(
			'models' => array(
				'Announcement' => array('save')
			)
		));
		$this->Controller->Announcement->expects($this->once())->method('save')
			->will($this->returnValue(false));

		$this->setExpectedException('InternalErrorException');
		$this->testAction(
			'/announcements/announcements/edit/1',
			array('data' => $this->__editInputData, 'method' => 'put')
		);
	}

/**
 * testBlockSettingGet method 表示
 *
 * @return void
 */
	public function testBlockSettingGet() {
		// 存在しないAnnouncement.block_idを指定
		$this->mockAuthUser(1);
		$result = $this->testAction('/announcements/announcements/block_setting/2', array('method' => 'get'));
		$this->assertRegExp('/<form/', $result);
		$this->assertTextNotContains('Mail Subject', $result);

		// 存在するAnnouncement.block_idを指定
		$this->mockAuthUser(1);
		$result = $this->testAction('/announcements/announcements/block_setting/1', array('method' => 'get'));
		$this->assertRegExp('/<form/', $result);
		$this->assertTextContains('Mail Subject', $result);
	}

/**
 * testBlockSettingPost method 登録(存在しないAnnouncement.block_idを指定)
 *
 * @return void
 */
	public function testBlockSettingPostNotExists() {
		$this->mockAuthUser(1);
		$this->testAction(
			'/announcements/announcements/block_setting/2',
			array('data' => $this->__blockSettingInputNoneExistData, 'method' => 'post')
		);

		$results = $this->AnnouncementBlock->findByBlockId(2);
		$this->assertEquals($results['AnnouncementBlock']['mail_subject'], 'Mail Subject');
	}

/**
 * testBlockSettingPostExists method 登録(存在するAnnouncement.block_idを指定)
 *
 * @return void
 */
	public function testBlockSettingPostExists() {
		// 存在するAnnouncement.block_idを指定
		$this->mockAuthUser(1);
		$this->testAction(
			'/announcements/announcements/block_setting/1',
			array('data' => $this->__blockSettingInputData, 'method' => 'put')
		);

		$results = $this->AnnouncementBlock->findByBlockId(1);
		$this->assertEquals($results['AnnouncementBlock']['mail_subject'], 'Mail Subject2');
	}

/**
 * testBlockSettingPostValidationError method 登録 ValidationError
 *
 * @return void
 */
	public function testBlockSettingPostValidationError() {
		$this->mockAuthUser(1);
		// 登録
		$data = $this->__blockSettingInputData;
		unset($data['BlocksLanguage']['name']);
		$data['AnnouncementBlock']['send_mail'] = 'AAA';

		$this->testAction(
			'/announcements/announcements/block_setting/1',
			array('data' => $data, 'method' => 'put')
		);
		$results = $this->AnnouncementBlock->findByBlockId(1);
		$this->assertEquals($results['AnnouncementBlock']['mail_subject'], 'Mail Subject');	// 変更されていないことの確認
	}

/**
 * testBlockSettingPostSaveError method
 * AnnouncementBlock save Error
 *
 * @return void
 */
	public function testBlockSettingPostSaveError() {
		$this->mockAuthUser(1, array(
			'models' => array(
				'AnnouncementBlock' => array('save')
			)
		));
		$this->Controller->AnnouncementBlock->expects($this->once())->method('save')
			->will($this->returnValue(false));

		$this->setExpectedException('InternalErrorException');
		$this->testAction(
			'/announcements/announcements/block_setting/1',
			array('data' => $this->__blockSettingInputData, 'method' => 'put')
		);
	}

/**
 * testBlockSettingPostBlocksLanguageSaveError method
 * BlocksLanguage save Error
 *
 * @return void
 */
	public function testBlockSettingPostBlocksLanguageSaveError() {
		$this->mockAuthUser(1);
		$this->getMockForModel('BlocksLanguage', array('save'))
			->expects($this->once())->method('save')
			->will($this->returnValue(false));

		$this->setExpectedException('InternalErrorException');
		$this->testAction(
			'/announcements/announcements/block_setting/1',
			array('data' => $this->__blockSettingInputData, 'method' => 'put')
		);
	}

/**
 * testBlockSettingPostMismatchData method
 * データ不整合なデータがきた場合
 *
 * @return void
 */
	public function testBlockSettingPostMismatchData() {
		$this->mockAuthUser(1);
		$data = array(
			'AnnouncementBlock' => array(
				'id' => 10,
				'block_id' => 1,
				'send_mail' => $this->__false,
				'mail_subject' => 'Mail Subject2',
				'mail_body' => 'Mail Body2'
			),
			'AnnouncementBlocksPart' => array(
				array(
					'id' => 10,
					'announcement_block_id' => 10,
					'part_id' => 1,
					'can_edit_content' => $this->__true,
					'can_publish_content' => $this->__true,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 11,
					'announcement_block_id' => 10,
					'part_id' => 2,
					'can_edit_content' => $this->__true,
					'can_publish_content' => $this->__true,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 12,
					'announcement_block_id' => 10,
					'part_id' => 3,
					'can_edit_content' => $this->__false,
					'can_publish_content' => $this->__false,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 13,
					'announcement_block_id' => 10,
					'part_id' => 4,
					'can_edit_content' => $this->__false,
					'can_publish_content' => $this->__false,
					'can_send_mail' => $this->__false,
				),
				array(
					'id' => 14,
					'announcement_block_id' => 10,
					'part_id' => 5
				),
				array(
					'id' => 15,
					'announcement_block_id' => 10,
					'part_id' => 6,
					'can_edit_content' => $this->__false,
					'can_publish_content' => $this->__false,
					'can_send_mail' => $this->__false,
				)
			),
			'BlocksLanguage' => array(
				'name' => 'Test Block',
			),
		);

		$this->testAction(
			'/announcements/announcements/block_setting/1',
			array('data' => $data, 'method' => 'put')
		);

		$results = $this->AnnouncementBlock->findByBlockId(1);
		$this->assertFalse($results[$this->AnnouncementBlocksPart->alias][4]['can_edit_content']);
		$this->assertFalse($results[$this->AnnouncementBlocksPart->alias][4]['can_publish_content']);
		$this->assertFalse($results[$this->AnnouncementBlocksPart->alias][4]['can_send_mail']);
		$this->assertEquals(count($results[$this->AnnouncementBlocksPart->alias]), 5);
	}

}
