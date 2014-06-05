<?php
/**
 * AnnouncementBlock Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementBlock', 'Model');

/**
 * Summary for AnnouncementBlock Test Case
 */
class AnnouncementBlockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.announcement_block'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementBlock = ClassRegistry::init('AnnouncementBlock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementBlock);

		parent::tearDown();
	}

}
