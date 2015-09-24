<?php
/**
 * AnnouncementBlocksController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementBlocksController', 'Announcements.Controller');
App::uses('BlocksControllerTest', 'Blocks.TestSuite');

/**
 * AnnouncementBlocksController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class IndexTest extends BlocksControllerTest {

/**
 * Set plugin name
 *
 * @var array
 */
	protected $_plugin = 'announcements';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'announcement_blocks';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
		'plugin.comments.comment',
	);

}
