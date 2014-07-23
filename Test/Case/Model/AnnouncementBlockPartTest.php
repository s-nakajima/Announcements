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
		'plugin.announcements.announcement_frame',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementBlockPart = ClassRegistry::init('Announcements.AnnouncementBlockPart');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementBlockPart);

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
		//var_dump($rtn);
		$this->assertTextEquals(1, $rtn["AnnouncementBlockPart"]['id']);
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
		$partId = 2;
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
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
	}

/**
 * getList blockIdから一覧を取得する
 *
 * @return void
 */
	public function testGetList() {
		$this->__setData();
		$blockId = 1;
		$rtn = $this->AnnouncementBlockPart->getList($blockId);
		$this->assertTrue(is_array($rtn));
		$this->assertEquals(1, $rtn[0][$this->AnnouncementBlockPart->name]['id']);
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
		$this->assertEquals($rtn[0][$this->AnnouncementBlockPart->name]["block_id"], $blockId);
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
 * block part updateの正常処理
 *
 * @return void
 */
	public function testUpdateParts() {
		//updateParts($type, $frameId, $data, $userId)
		$type = "publish";
		$userId = 2;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		//1件もない状態での実行
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
		//データがあったところからのupdate
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
	}

/**
 * block part update 正常処理　typeがedit
 *
 * @return void
 */
	public function testUpdatePartsTypeEdit() {
		//updateParts($type, $frameId, $data, $userId)
		$type = "edit";
		$userId = 1;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		//1件もない状態での実行
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
		//データがあったところからのupdate
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));

		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => "2" //2だけ
		);
		//データがあったところからのupdate
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
	}

/**
 * block part update partIdがないのでエラーが発生している状態
 *
 * @return void
 */
	public function testUpdatePartsPartIdNull() {
		$type = "publish";
		$userId = 2;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
		);
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(array(), $rtn);
	}

/**
 * blockidをframeから取得する
 *
 * @return void
 */
	public function testGetBlockIdByFrame() {
		$frame = array();
		$rtn = $this->AnnouncementBlockPart->getBlockIdByFrame($frame);
		$this->assertNull($rtn);
	}

/**
 * blockidをframeから取得する 該当するframeIdが無い場合
 *
 * @return void
 */
	public function testUpdatePartsNoticeFrameId() {
		$type = "publish";
		$userId = 2;
		$frameId = 10000000;
		$data = array(
			'frame_id' => 10000000,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(array(), $rtn);
	}

/**
 * block partsの更新 typeが想定外
 *
 * @return void
 */
	public function testUpdatePartsTypeError() {
		$type = "test";
		$userId = 1;
		$frameId = 1;
		$data = array(
			'frame_id' => 1,
			'block_id' => 1,
			'part_id' => "2,3,4"
		);
		//1件もない状態での実行
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
		//データがあったところからのupdate
		$rtn = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $userId);
		$this->assertEquals(true, is_array($rtn));
	}

}
