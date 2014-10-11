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
	public $uses = array(
		'Announcements.Announcement',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsBlock',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//未ログインでもアクセスを許可
		$this->Auth->allow();
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0) {
		return $this->view($frameId);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0) {
		$result = $this->NetCommonsFrame->setView($this, $frameId);
		if (! $result) {
			return $this->render(false);
		}
var_dump($this->viewVars);

		$announcement = $this->Announcement->get(
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);

		$this->set('announcement', $announcement);

		return $this->render('Announcements/view');
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0) {
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
