<?php
/**
 * AnnouncementPartsSetting Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementPartsSetting', 'Announcements.Model');

/**
 * Summary for AnnouncementPartsSetting Test Case
 */
class AnnouncementPartsSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_parts_setting',
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
		$this->AnnouncementPartsSetting = ClassRegistry::init('Announcements.AnnouncementPartsSetting');
		CakeSession::write('Auth.User.id', 1);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementPartsSetting);
		parent::tearDown();
	}

/**
 * testGetList method
 *
 * @return void
 */
	public function testGetList() {
		$blockId = 1;
		$rtn = $this->AnnouncementPartsSetting->getList($blockId);
		$this->assertEquals(
			$blockId,
			$rtn[0][$this->AnnouncementPartsSetting->name]['block_id']
		);
	}

/**
 * testFindByBlockId method
 *
 * @return void
 */
	public function testGet() {
		//パートの権限を取得する
		$blockId = 1;
		$partId = 1;
		$rtn = $this->AnnouncementPartsSetting->get($blockId, $partId);
		$this->assertEquals(
			$partId,
			$rtn[$this->AnnouncementPartsSetting->name]['part_id']
		);
	}

/**
 * getListPartIdArray
 *
 * @return void
 */
	public function testGetListPartIdArray() {
		//keyとvalueがpart_idになるブロックのパートを取得する
		$blockId = 1;
		$partId = 1;
		$rtn = $this->AnnouncementPartsSetting->getListPartIdArray($blockId);
		$this->assertEquals(
			$rtn[$partId]['part_id'],
			$partId
		);

		//ない場合
		$blockId = 10000;
		$rtn = $this->AnnouncementPartsSetting->getListPartIdArray($blockId);
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
		$blockId = 1;
		$partId = 1;
		$ans = $this->AnnouncementPartsSetting->get($blockId, $partId);
		$rtn = $this->AnnouncementPartsSetting->getIdByBlockId($blockId, $partId);
		$this->assertEquals(
			$ans[$this->AnnouncementPartsSetting->name]['id'],
			$rtn
		);
		//ない場合
		$blockId = 1;
		$partId = 100000;
		$rtn = $this->AnnouncementPartsSetting->getIdByBlockId($blockId, $partId);
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
	public function testChangeablePartList() {
		$colName = 'read_content';
		$rtn = $this->AnnouncementPartsSetting->changeablePartList($colName);
		$this->assertTrue(is_array($rtn));

		$colName = 'edit_content';
		$rtn = $this->AnnouncementPartsSetting->changeablePartList($colName);
		$this->assertTrue(is_array($rtn));

		$colName = 'create_content';
		$rtn = $this->AnnouncementPartsSetting->changeablePartList($colName);
		$this->assertTrue(is_array($rtn));

		$colName = 'publish_content';
		$rtn = $this->AnnouncementPartsSetting->changeablePartList($colName);
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
		$rtn = $this->AnnouncementPartsSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		//利用できないpermissionType
		$permissionType = 'test';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2, 3, 4',
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartsSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		//ERROR: postされたデータにpart_idがない
		$permissionType = 'edit';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartsSetting->updateParts($permissionType, $frameId, $blockId, $data);
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
		$rtn = $this->AnnouncementPartsSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		//存在した
		$blockId = 1;
		$this->assertTrue($this->AnnouncementPartsSetting->createSetting($blockId));
		$permissionType = 'publish';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2',
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartsSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		//存在した
		$blockId = 1;
		$this->assertTrue($this->AnnouncementPartsSetting->createSetting($blockId));
		$permissionType = 'publish';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2',
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartsSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));

		$permissionType = 'publish';
		$frameId = 1;
		$blockId = 1;
		$data = array(
			'part_id' => '2, 3, 4',
			'frame_id' => 1
		);
		$rtn = $this->AnnouncementPartsSetting->updateParts($permissionType, $frameId, $blockId, $data);
		$this->assertTrue(is_array($rtn));
	}
}
