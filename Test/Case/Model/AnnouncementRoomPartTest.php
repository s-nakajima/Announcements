<?php
/**
 * Announcement Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementRoomPart', 'Announcements.Model');
App::uses('AnnouncementRoom', 'Announcements.Model');
App::uses('LanguagesPart', 'Announcements.Model');


/**
 * Summary for Announcement Test Case
 */
class AnnouncementRoomPartTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.room_part',
		'app.part',
		'app.language',
		'app.languages_part'
	);

	public $RoomPart;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RoomPart = ClassRegistry::init('Announcements.AnnouncementRoomPart');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RoomPart);
		parent::tearDown();
	}

/**
 * getList
 *
 * @return void
 */
	public function testGetList() {
		$rtn = $this->RoomPart->getList();
		$this->assertTrue(isset($rtn));
	}
}
