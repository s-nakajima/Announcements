<?php
/**
 * Announcements Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsAppController', 'Announcements.Controller');

/**
 * Announcements Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Controller
 */
class AnnouncementsController extends AnnouncementsAppController {

/**
 * use model
 *
 * @var array
 */
	//public $uses = array();

/**
 * use component
 *
 * @var array
 */
	//public $components = array();

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @param string $lang ex)"en" or "ja" etc.
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0, $lang = '') {
		return $this->render('Announcements/index');
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param string $lang ex)"en" or "ja" etc.
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0, $lang = '') {
		return $this->render('Announcements/view');
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @param int $languageId languages.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0, $languageId = 0) {
		return $this->render('Announcements/form');
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @return string JSON that indicates success
 */
	public function edit($frameId = 0) {
		return;
	}
}
