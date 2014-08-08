<?php
/**
 * AnnouncementDatum Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementDatum', 'Announcements.Model');
App::uses('AnnouncementFrame', 'Announcements.Model');

/**
 * Summary for AnnouncementDatum Test Case
 */
class AnnouncementDatumTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_datum',
		'plugin.announcements.announcement',
		'plugin.announcements.announcement_frame',
		'plugin.announcements.announcement_block_block'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementDatum = ClassRegistry::init('Announcements.AnnouncementDatum');
		$this->AnnouncementFrame = ClassRegistry::init('Announcements.AnnouncementFrame');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementDatum);
		unset($this->AnnouncementFrame);
		parent::tearDown();
	}

/**
 * saveData
 *
 * @return void
 */
	public function testSaveData() {
		$data = array();
		$data['AnnouncementDatum']['content'] = "test";
		$data['AnnouncementDatum']['frameId'] = 1;
		$data['AnnouncementDatum']['blockId'] = 0;
		$data['AnnouncementDatum']['type'] = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$frameId = 1;
		$userId = 1;
		$isEncode = false;
		$rtn = $this->AnnouncementDatum->saveData($data, $frameId, $userId, $isEncode);
		$this->assertTrue(is_numeric($rtn['AnnouncementDatum']['id']));
		$this->assertTextEquals($rtn['AnnouncementDatum']['status_id'], 3);
		$this->assertTextEquals($rtn['AnnouncementDatum']['content'], "test");
	}

/**
 * saveData no Flame ID
 *
 * @return void
 */
	public function testSaveDataNoFrame() {
		$data = array();
		$data['AnnouncementDatum']['content'] = "test";
		$data['AnnouncementDatum']['frameId'] = 9999999999;
		$data['AnnouncementDatum']['blockId'] = 0;
		$data['AnnouncementDatum']['type'] = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$frameId = 9999999999;
		$userId = 1;
		$isEncode = false;
		$rtn = $this->AnnouncementDatum->saveData($data, $frameId, $userId, $isEncode);
		$this->assertNull($rtn);
	}

/**
 * frames.block_idが0の場合に、blockを作成してから、登録する
 *
 * @return void
 */
	public function testSaveDataNoBlockId() {
		$frameData = array(
			'room_id' => 1,
			'box_id' => 2,
			'plugin_id' => 1,
			'block_id' => null,
			'weight' => 1
		);
		$rtn = $this->AnnouncementFrame->save($frameData);
		//var_dump($rtn);
		$frameId = $rtn["AnnouncementFrame"]['id'];
		$data = array();
		$data['AnnouncementDatum']['content'] = "test";
		$data['AnnouncementDatum']['frameId'] = $frameId;
		$data['AnnouncementDatum']['blockId'] = 0;
		$data['AnnouncementDatum']['type'] = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$userId = 1;
		$isEncode = false;
		$rtn = $this->AnnouncementDatum->saveData($data, $frameId, $userId, $isEncode);
		$this->assertTextEquals(3, $rtn[$this->AnnouncementDatum->name]['id']);
	}

/**
 * saveData Ajax
 *
 * @return void
 */
	public function testSaveDataIsAjax() {
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 1;
		$data['AnnouncementDatum']['blockId'] = 0;
		$data['AnnouncementDatum']['type'] = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$frameId = 1;
		$userId = 1;
		$isEncode = true;
		$rtn = $this->AnnouncementDatum->saveData($data, $frameId, $userId, $isEncode);
		$this->assertTrue(is_numeric($rtn['AnnouncementDatum']['id']));
		$this->assertTextEquals($rtn['AnnouncementDatum']['status_id'], 3);
		$this->assertTextEquals($rtn['AnnouncementDatum']['content'], "test");
	}

/**
 * saveData
 *
 * @return void
 */
	public function testSaveDataIsAjaxNoBlockId() {
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 2;
		$data['AnnouncementDatum']['blockId'] = 0;
		$data['AnnouncementDatum']['type'] = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$frameId = 1;
		$userId = 1;
		$isEncode = true;
		$rtn = $this->AnnouncementDatum->saveData($data, $frameId, $userId, $isEncode);
		$this->assertTrue(is_numeric($rtn['AnnouncementDatum']['id']));
		$this->assertTextEquals($rtn['AnnouncementDatum']['status_id'], 3);
		$this->assertTextEquals($rtn['AnnouncementDatum']['content'], "test");
	}

/**
 * testSaveData_NewBlock
 *
 * @return void
 */
	public function testSaveDataNewBlock() {
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['blockId'] = 100;
		$data['AnnouncementDatum']['type'] = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$frameId = 2;
		$userId = 1;
		$isEncode = true;
		$rtn = $this->AnnouncementDatum->saveData($data, $frameId, $userId, $isEncode);
		$this->assertTrue(is_numeric($rtn['AnnouncementDatum']['id']));
		$this->assertTextEquals($rtn['AnnouncementDatum']['status_id'], 3);
		$this->assertTextEquals($rtn['AnnouncementDatum']['content'], "test");
	}

/**
 * saveData
 *
 * @return void
 */
	public function testGetDataIsSetting() {
		$blockId = 1;
		$lang = 2;
		$isSetting = 1;
		//セッティングモードなので下書きを含む最新がとれる
		$rtn = $this->AnnouncementDatum->getData($blockId, $lang, $isSetting);
		$this->assertTextEquals($rtn['AnnouncementDatum']['id'], 1);
	}

/**
 * saveData
 *
 * @return void
 */
	public function testGetData() {
		$blockId = 1;
		$lang = 2;
		$isSetting = 0;
		$rtn = $this->AnnouncementDatum->getData($blockId, $lang, $isSetting);
		//セッティングモードOFFなので公開情報がとれる
		$this->assertTextEquals($rtn['AnnouncementDatum']['id'], 1);
	}

/**
 * save checker
 *
 * @return void
 */
	public function testCheckDataSave() {
		$data = array(
			'AnnouncementDatum' => array(
				'id' => 1,
				'test' => 1
			)
		);
		$rtn = $this->AnnouncementDatum->checkDataSave($data);
		$this->assertEquals($data, $rtn);
		//null
		$data = array();
		$rtn = $this->AnnouncementDatum->checkDataSave($data);
		$this->assertEquals(null, $rtn);
	}

}
