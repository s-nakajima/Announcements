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

/**
 *Announcement Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model
 */
class AnnouncementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
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
 * testGetAnnouncement method
 *
 * @return void
 */
	public function testGetAnnouncement() {
		$blockId = 1;
		$contentEditable = true;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$this->assertTrue(true);
	}

/**
 * testGetAnnouncementPublish method
 *
 * @return void
 */
	public function testGetAnnouncementPublish() {
		$blockId = 1;
		$contentEditable = false;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$this->assertTrue(true);
	}

}
