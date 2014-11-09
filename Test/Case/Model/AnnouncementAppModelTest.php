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
class AnnouncementAppModelTest extends CakeTestCase {

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
		'plugin.rooms.room',
		'plugin.announcements.user_attributes_user',
		'plugin.announcements.user',
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
		$this->Announcement = ClassRegistry::init('Announcements.Announcement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Announcement);
		parent::tearDown();
	}

/**
 * _assertGetAnnouncement method
 *
 * @param array $expected correct data
 * @param array $result result data
 * @return void
 */
	protected function _assertGetAnnouncement($expected, $result) {
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
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}
}
