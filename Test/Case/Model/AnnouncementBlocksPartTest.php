<?php
/**
 * AnnouncementBlocksPart Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementBlocksPart', 'Model');

/**
 * Summary for AnnouncementBlocksPart Test Case
 */
class AnnouncementBlocksPartTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.announcement_blocks_part'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementBlocksPart = ClassRegistry::init('AnnouncementBlocksPart');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementBlocksPart);

		parent::tearDown();
	}

}
