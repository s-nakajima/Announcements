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
//App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
//App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * Announcement Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model
 */
class AnnouncementModelTestBase extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
		//'plugin.comments.comment',
	);

}
