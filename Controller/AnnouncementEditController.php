<?php
/**
 * Announcement edit Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsAppController', 'Announcements.Controller');

/**
 * Announcement edit Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Controller
 */
class AnnouncementEditController extends AnnouncementsAppController {

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
		'NetCommons.NetCommonsBlock', //use Announcement model or view
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		$frameId = (isset($this->params['pass'][0]) ? (int)$this->params['pass'][0] : 0);

		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			$this->response->statusCode(400);
			return;
		}

		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			$this->response->statusCode(403);
			return;
		}

		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			$this->response->statusCode(400);
			return;
		}
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
		if ($this->response->statusCode() !== 200) {
			return $this->render(false);
		}

		//Announcementデータを取得
		$announcement = $this->Announcement->getAnnouncement(
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);

		$this->set('announcement', $announcement);

		return $this->render('AnnouncementEdit/view', false);
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0) {
		$this->view($frameId);
		return $this->render('AnnouncementEdit/form', false);
	}

/**
 * post method
 *
 * @param int $frameId frames.id
 * @return string JSON that indicates success
 */
	public function post($frameId = 0) {
		if ($this->response->statusCode() !== 200) {
			$statusCode = $this->response->statusCode();
			$message = __d('announcements', 'Save failed.');
			return $this->NetCommonsFrame->renderJson($this, $statusCode, $message);
		}
		if (! $this->request->isPost()) {
			$message = __d('announcements', 'Save failed.');
			return $this->NetCommonsFrame->renderJson($this, 400, $message);
		}

		//保存
		if ($this->Announcement->saveAnnouncement($this->data)) {
			$message = __d('announcements', 'Success saved.');
			return $this->NetCommonsFrame->renderJson($this, 200, $message);
		} else {
			$message = __d('announcements', 'Save failed.');
			return $this->NetCommonsFrame->renderJson($this, 400, $message);
		}
	}
}
