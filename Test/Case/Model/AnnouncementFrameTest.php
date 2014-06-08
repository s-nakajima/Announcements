<?php
/**
 * Announcement Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementFrame', 'Announcements.Model');
app::uses('Frame', 'Model');

/**
 * Summary for Announcement Test Case
 */
class AnnouncementFrameTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.FrameFixture'
	);

	public $Frame;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Frame = ClassRegistry::init('Announcements.AnnouncementFrame');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Frame);

		parent::tearDown();
	}

}
