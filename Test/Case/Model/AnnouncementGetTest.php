<?php
/**
 * Announcement Model Test Case
 *
 * @property Announcement $Announcement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Announcement', 'Announcements.Model');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');

/**
 *Announcement Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model
 */
class AnnouncementGetTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
		'plugin.announcements.block',
		'plugin.frames.box',
		'plugin.frames.language',
		'plugin.announcements.frame',
		'plugin.announcements.plugin',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		//$this->Language = ClassRegistry::init('Language');
		$this->Announcement = ClassRegistry::init('Announcements.Announcement');
		$this->Block = ClassRegistry::init('Blocks.Block');
		//$this->Block = $this->getMockByModel('Blocks.Block', array('save'));
		//$this->Block->expects($this->once())
		//		->method('save')
		//		->will($this->returnValue(false));
		//ClassRegistry::addObject('block');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Announcement);
		unset($this->Block);
		parent::tearDown();
	}

/**
 * __assertGetAnnouncement method
 *
 * @param array $expected correct data
 * @param array $result result data
 * @return void
 */
	private function __assertGetAnnouncement($expected, $result) {
		$unsets = array(
			'created_user',
			'created',
			'modified_user',
			'modified'
		);

		//Announcementデータのテスト
		foreach ($unsets as $key) {
			if (array_key_exists($key, $result['Announcement'])) {
				unset($result['Announcement'][$key]);
			}
		}

		$this->assertArrayHasKey('Announcement', $result, 'Error ArrayHasKey Announcement');
		$this->assertEquals($expected['Announcement'], $result['Announcement'], 'Error Equals Announcement');

		//Blockデータのテスト
		if (isset($expected['Block'])) {
			foreach ($unsets as $key) {
				if (array_key_exists($key, $result['Block'])) {
					unset($result['Block'][$key]);
				}
			}

			$this->assertArrayHasKey('Block', $result, 'Error ArrayHasKey Block');
			$this->assertEquals($expected['Block'], $result['Block'], 'Error Equals Block');
		}
	}

/**
 * testGetAnnouncement method
 *
 * @return void
 */
	public function testGetAnnouncement() {
		$blockId = 1;
		$contentEditable = true;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$expected = array(
			'Announcement' => array(
				'id' => '2',
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '3',
				'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
				'is_auto_translated' => true,
				'translation_engine' => 'Lorem ipsum dolor sit amet',
			),
			'Block' => array(
				'id' => '1',
				'language_id' => '2',
				'room_id' => '1',
				'key' => 'block_1',
				'name' => '',
			)
		);

		$this->__assertGetAnnouncement($expected, $result);
	}

/**
 * testGetAnnouncementByNoEditable method
 *
 * @return void
 */
	public function testGetAnnouncementByNoEditable() {
		$blockId = 1;
		$contentEditable = false;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$expected = array(
			'Announcement' => array(
				'id' => '1',
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
				'is_auto_translated' => true,
				'translation_engine' => 'Lorem ipsum dolor sit amet',
			),
			'Block' => array(
				'id' => '1',
				'language_id' => '2',
				'room_id' => '1',
				'key' => 'block_1',
				'name' => '',
			)
		);

		$this->__assertGetAnnouncement($expected, $result);
	}

/**
 * testGetAnnouncementByNoBlockId method
 *
 * @return void
 */
	public function testGetAnnouncementByNoBlockId() {
		$blockId = 0;
		$contentEditable = false;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$expected = array(
			'Announcement' => array(
				'block_id' => '0',
				'key' => '',
				'status' => '0',
				'content' => '',
				'is_auto_translated' => '0',
				'key' => '',
				'id' => '0'
			),
		);

		$this->__assertGetAnnouncement($expected, $result);
	}
}
