<?php
/**
 * AnnouncementsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsController', 'Announcements.Controller');
App::uses('AnnouncementsAppControllerTest', 'Announcements.Test/Case/Controller');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerTest extends AnnouncementsAppControllerTest {

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->_generateController('Announcements.Announcements');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction('/announcements/announcements/index/1', array('method' => 'get'));

		$expected = 'Lorem ipsum dolor sit amet, aliquet feugiat. ' .
				'Convallis morbi fringilla gravida, ' .
				'phasellus feugiat dapibus velit nunc, ' .
				'pulvinar eget sollicitudin venenatis cum nullam, ' .
				'vivamus ut a sed, mollitia lectus. ' .
				'Nulla vestibulum massa neque ut et, id hendrerit sit, ' .
				'feugiat in taciti enim proin nibh, ' .
				'tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.';
		$this->assertTextContains($expected, $this->view);
	}

/**
 * testIndexByNewFrameId method
 *
 * @return void
 */
	public function testIndexByNewFrameId() {
		$this->testAction('/announcements/announcements/index/3', array('method' => 'get'));

		$this->assertEmpty(trim($this->view));
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$this->testAction('/announcements/announcements/view/1', array('method' => 'get'));

		$expected = 'Lorem ipsum dolor sit amet, aliquet feugiat. ' .
				'Convallis morbi fringilla gravida, ' .
				'phasellus feugiat dapibus velit nunc, ' .
				'pulvinar eget sollicitudin venenatis cum nullam, ' .
				'vivamus ut a sed, mollitia lectus. ' .
				'Nulla vestibulum massa neque ut et, id hendrerit sit, ' .
				'feugiat in taciti enim proin nibh, ' .
				'tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.';
		$this->assertTextContains($expected, $this->view);
	}

/**
 * testViewByNewFrameId method
 *
 * @return void
 */
	public function testViewByNewFrameId() {
		$this->testAction('/announcements/announcements/view/3', array('method' => 'get'));
		$this->assertEmpty(trim($this->view));
	}
}
