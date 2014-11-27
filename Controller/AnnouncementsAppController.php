<?php
/**
 * AnnouncementsApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

//TODO: AppControllerがNetCommonsAppControllerを継承する
//App::uses('AppController', 'Controller');
App::uses('NetCommonsAppController', 'NetCommons.Controller');

/**
 * AnnouncementsApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Controller
 */
class AnnouncementsAppController extends NetCommonsAppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Security'
	);
}
