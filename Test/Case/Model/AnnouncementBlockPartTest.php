<?php
/**
 * AnnouncementBlockPart Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementBlockPart', 'Announcements.Model');

/**
 * Summary for AnnouncementBlockPart Test Case
 * @SuppressWarnings(PHPMD)
 */
class AnnouncementBlockPartTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement_block_part',
		'app.room_part',
		'plugin.net_commons.net_commons_frame',
		'plugin.announcements.announcement_block_block',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementBlockPart = ClassRegistry::init('Announcements.AnnouncementBlockPart');
		$this->Frame = ClassRegistry::init('NetCommons.NetCommonsFrame');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementBlockPart);
		unset($this->Frame);

		parent::tearDown();
	}

/**
 * findByBlockId
 *
 * @return void
 */
	public function testFindByBlockId() {
		$this->__setData();
		//ある場合
		$blockId = 1;
		$partId = 2;
		$rtn = $this->AnnouncementBlockPart->findByBlockId($blockId, $partId);
		$this->assertTextEquals(1, $rtn["AnnouncementBlockPart"]['block_id']);
		//無い場合
		$blockId = 100;
		$rtn = $this->AnnouncementBlockPart->findByBlockId($blockId, $partId);
		$this->assertEquals(array(), $rtn);
	}

/**
 * getIdByBlockId
 *
 * @return void
 */
	public function testGetIdByBlockId() {
		$this->__setData();
		//ある場合
		$blockId = 1;
		$partId = 1;
		$rtn = $this->AnnouncementBlockPart->getIdByBlockId($blockId, $partId);
		$this->assertTextEquals(1, $rtn);
		//無い場合
		$blockId = 100;
		$rtn = $this->AnnouncementBlockPart->getIdByBlockId($blockId, $partId);
		$this->assertEquals(null, $rtn);
	}

/**
 * テスト用のDATAを作成する。
 *
 * @return void
 */
	private function __setData() {
		$type = "publish";
		$userId = 2;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		//1件もない状態での実行
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
	}

/**
 * block_idがないデータをテスト用に作る
 *
 * @return mixed
 */
	private function __setData2() {
		$data = array(
			'id' => 1,
			'room_id' => 1,
			'box_id' => 1,
			'plugin_id' => 1,
			'block_id' => 0,
			'weight' => 1,
			'is_published' => 1,
			'created_user_id' => 1,
			'created' => '2014-07-24 02:55:51',
		);
		$frame = $this->Frame->save($data);
		return $frame[$this->Frame->name]['id'];
	}

/**
 * block room 作成のテスト
 *
 * @return void
 */
	public function testCreateBlockPart() {
		$blockId = 1000;
		$userId = 2;
		$rtn = $this->AnnouncementBlockPart->createBlockPart($blockId, $userId);
		$this->assertEquals($rtn[1][$this->AnnouncementBlockPart->name]["block_id"], $blockId);
	}

/**
 * block part 作成のテスト blockIdが0
 *
 * @return void
 */
	public function testCreateBlockPartBlockIdZero() {
		$blockId = 0;
		$userId = 2;
		$rtn = $this->AnnouncementBlockPart->createBlockPart($blockId, $userId);
		$this->assertEquals(null, $rtn);
	}

/**
 * block part 作成のテストerror
 *
 * @return void
 */
	public function testCreateBlockPartError() {
		$blockId = 1000;
		$userId = 2;
		$this->AnnouncementBlockPart->validate = array(
			'block_id' => 'email'
		);
		$rtn = $this->AnnouncementBlockPart->createBlockPart($blockId, $userId);
		$this->assertEquals(null, $rtn);
	}

/**
 * block part updateの正常処理
 *
 * @return void
 */
	public function testUpdatePartsAbility() {
		$type = "publish";
		$userId = 2;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		//1件もない状態での実行
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
		//データがあったところからのupdate
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
	}

/**
 * block part update 正常処理　typeがedit
 *
 * @return void
 */
	public function testUpdatePartsAbilityTypeEdit() {
		$type = "edit";
		$userId = 1;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		//1件もない状態での実行
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
		//データがあったところからのupdate
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => '2' //2だけ
		);
		//データがあったところからのupdate
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
	}

/**
 * block part update partIdがないのでエラーが発生している状態
 *
 * @return void
 */
	public function testUpdatePartsAbilityPartIdNull() {
		$type = "publish";
		$userId = 2;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
		);
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(array(), $rtn);
	}

/**
 * blockidをframeから取得する
 *
 * @return void
 */
	public function testGetBlockIdByFrame() {
		$frame = array();
		//$rtn = $this->AnnouncementBlockPart->getBlockIdByFrame($frame);
		//$this->assertNull($rtn);
	}

/**
 * blockidをframeから取得する 該当するframeIdが無い場合
 *
 * @return void
 */
	public function testUpdatePartsAbilityNoticeFrameId() {
		$type = "publish";
		$userId = 2;
		$frameId = 10000000;
		$data = array(
			'frame_id' => 10000000,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(array(), $rtn);
	}

/**
 * block partsの更新 typeが想定外
 *
 * @return void
 */
	public function testUpdatePartsAbilityTypeError() {
		$type = "test";
		$userId = 1;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		//1件もない状態での実行
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(array(), $rtn);
		//データがあったところからのupdate
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(array(), $rtn);
	}

/**
 * block part updateの正常処理 frames.block_idが0の場合
 *
 * @return void
 */
	public function testUpdatePartsNoBlock() {
		$type = "publish";
		$userId = 2;
		$frameId = $this->__setData2();
		$data = array(
			'frame_id' => $frameId,
			'block_id' => 0,
			'part_id' => "2"
		);
		//1件もない状態での実行
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		//blockが新規作成された上で更新されるのでroom_partの数だけ値が戻る
		$this->assertEquals(5, count($rtn));
	}

/**
 * block part
 *
 * @return void
 */
	public function testUpdatePartsNoBlockError() {
		$type = "publish";
		$userId = 2;
		$frameId = $this->__setData2();
		$data = array(
			'frame_id' => $frameId,
			'block_id' => 0,
			'part_id' => "2"
		);
		//1件もない状態での実行
		//エラーに絶対なっちゃうバリデーションルール設定
		$this->AnnouncementBlockPart->validate = array(
			'block_id' => 'email'
		);
		$rtn = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $userId);
		$this->assertEquals(0, count($rtn));
	}

/**
 * 配列にblockIdが無かった場合
 *
 * @return void
 */
	public function testGetBlockIdByFrameNoBlock() {
		$frame = array();
		$userId = 1;
		$rtn = $this->AnnouncementBlockPart->getBlockIdByFrame($frame, $userId);
		$this->assertNull($rtn);
	}

/**
 * getListPartIdArray
 *
 * @return void
 */
	public function testGetList() {
		//データ無し
		$blockId = 1;
		$rtn = $this->AnnouncementBlockPart->getListPartIdArray($blockId);
		$this->assertEquals(array(), $rtn);

		//データ有り
		$this->__setData();
		$rtn = $this->AnnouncementBlockPart->getListPartIdArray($blockId);
		$this->assertEquals(5, count($rtn));

		//データ無し
		$blockId = 100000000;
		$rtn = $this->AnnouncementBlockPart->getListPartIdArray($blockId);
		$this->assertEquals(array(), $rtn);
	}

/**
 * updateColum
 *
 * @return void
 */
	public function testUpdateColumn() {
		//レコードが無い
		$partIdList = array(2, 3);
		$columnName = "publish_content";
		$value = 1;
		$blockId = 1;
		$userId = 1;
		$rtn = $this->AnnouncementBlockPart->updateColumn($partIdList, $columnName, $value, $blockId, $userId);
		$this->assertEquals(false, $rtn);

		//レコードが有る
		$this->__setData();
		$rtn = $this->AnnouncementBlockPart->updateColumn($partIdList, $columnName, $value, $blockId, $userId);
		$this->assertEquals(true, $rtn);

		//レコードが有るがvalidate error
		$partIdList = array(2, 3);
		$columnName = "publish_content";
		$value = 1;
		$blockId = 1;
		$userId = '';
		$rtn = $this->AnnouncementBlockPart->updateColumn($partIdList, $columnName, $value, $blockId, $userId);
		$this->assertEquals(false, $rtn);
	}
}
