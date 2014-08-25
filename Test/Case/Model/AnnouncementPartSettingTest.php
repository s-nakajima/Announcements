<?php
/**
 * AnnouncementPartSetting Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementPartSetting', 'Announcements.Model');

/**
 * Summary for AnnouncementPartSetting Test Case
 */
class AnnouncementPartSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_part_setting',
		'app.block',
		'app.blocks_language',
		'app.room_part',
		'app.part',
		'app.languages_part',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementPartSetting = ClassRegistry::init('Announcements.AnnouncementPartSetting');
		CakeSession::write('Auth.User.id', 1);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementPartSetting);
		parent::tearDown();
	}

/**
 * testGetList method
 *
 * @return void
 */
	public function estGetList() {
		$blockId = 1;
		$rtn = $this->AnnouncementPartSetting->getList($blockId);
		$this->assertEquals(
			$blockId,
			$rtn[0][$this->AnnouncementPartSetting->name]['block_id']
		);
	}

/**
 * testFindByBlockId method
 *
 * @return void
 */
	public function estGet() {
		//パートの権限を取得する
		$blockId = 1;
		$partId = 1;
		$rtn = $this->AnnouncementPartSetting->get($blockId, $partId);
		$this->assertEquals(
			$partId,
			$rtn[$this->AnnouncementPartSetting->name]['part_id']
		);
	}

/**
 * getListPartIdArray
 *
 * @return void
 */
	public function estGetListPartIdArray() {
		//keyとvalueがpart_idになるブロックのパートを取得する
		$blockId = 1;
		$partId = 1;
		$rtn = $this->AnnouncementPartSetting->getListPartIdArray($blockId);
		$this->assertEquals(
			$rtn[$partId]['part_id'],
			$partId
		);

		//ない場合
		$blockId = 10000;
		$rtn = $this->AnnouncementPartSetting->getListPartIdArray($blockId);
		$this->assertEquals(
			$rtn,
			array()
		);
	}

/**
 * getIdByBlockId
 *
 * @return void
 */
	public function testGetIdByBlockId() {
		//ある場合
		//$blockId = 1;
		//$partId = 1;
		//$ans = $this->AnnouncementPartSetting->get($blockId, $partId);
		//$rtn = $this->AnnouncementPartSetting->getIdByBlockId($blockId, $partId);
		//$this->assertEquals(
		//	$ans[$this->AnnouncementPartSetting->name]['id'],
		//	$rtn
		//);
		//ない場合
		$blockId = 1;
		$partId = 100000;
		$rtn = $this->AnnouncementPartSetting->getIdByBlockId($blockId, $partId);
		$this->assertEquals(
			null,
			$rtn
		);
	}

/**
 * changeablePartList
 *
 * @return void
 */
	public function estChangeablePartList() {
		$colName = 'read_content';
		$rtn = $this->AnnouncementPartSetting->changeablePartList($colName);
		$this->assertTrue(is_array($rtn));

		$colName = 'edit_content';
		$rtn = $this->AnnouncementPartSetting->changeablePartList($colName);
		$this->assertTrue(is_array($rtn));

		$colName = 'create_content';
		$rtn = $this->AnnouncementPartSetting->changeablePartList($colName);
		$this->assertTrue(is_array($rtn));

		$colName = 'publish_content';
		$rtn = $this->AnnouncementPartSetting->changeablePartList($colName);
		$this->assertTrue(is_array($rtn));
	}

/**
 * update
 *
 * @return void
 */
	public function estUpdate() {
		//変更権限の付与
		$permissionType = 'edit';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2, 3, 4',
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		//利用できないpermissionType
		$permissionType = 'test';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2, 3, 4',
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		//ERROR: postされたデータにpart_idがない
		$permissionType = 'edit';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));
		$this->assertEquals(array(), $rtn);

		//すでに設定があるものを更新する。
		$permissionType = 'edit';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2, 3, 4',
			'frame_id' => 1
		);
		$this->assertEquals(array(), $rtn);
		$rtn = $this->AnnouncementPartSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		//存在した
		$blockId = 1;
		$this->assertTrue($this->AnnouncementPartSetting->createSetting($blockId));
		$permissionType = 'publish';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2',
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		//存在した
		$blockId = 1;
		$this->assertTrue($this->AnnouncementPartSetting->createSetting($blockId));
		$permissionType = 'publish';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2',
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		$permissionType = 'publish';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2, 3, 4',
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));
	}
}
