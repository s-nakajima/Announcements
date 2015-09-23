<?php
/**
 * AnnouncementsControllerTestBase
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

//App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
//App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
//App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
//App::uses('RolesControllerTest', 'Roles.Test/Case/Controller');
//App::uses('AuthGeneralControllerTest', 'AuthGeneral.Test/Case/Controller');

/**
 * AnnouncementsControllerTestBase
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class AnnouncementsControllerTestBase extends NetCommonsControllerTestCase {

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
