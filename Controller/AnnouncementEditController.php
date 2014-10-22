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
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException();
		}

		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			throw new ForbiddenException();
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
 * @throws ForbiddenException
 */
	public function view($frameId = 0) {
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException();
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
 * @return string JSON that indicates success
 * @throws MethodNotAllowedException
 * @throws ForbiddenException
 */
	public function edit() {
		if (! $this->request->isPost()) {
			throw new MethodNotAllowedException();
		}

		$postData = $this->data;
		unset($postData['Announcement']['id']);

		$frameId = (isset($postData['Frame']['id']) ? (int)$postData['Frame']['id'] : 0);
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException();
		}

		//登録
		$result = $this->Announcement->saveAnnouncement($postData);
		if (! $result) {
			throw new ForbiddenException(__d('net_commons', 'Failed to register data.'));
		}

		$announcement = $this->Announcement->getAnnouncement(
				$result['Announcement']['block_id'],
				$this->viewVars['contentEditable']
			);

		$result = array(
			'name' => __d('net_commons', 'Successfully finished.'),
			'announcement' => $announcement,
		);

		$this->set(compact('result'));
		$this->set('_serialize', 'result');
		return $this->render(false);
	}
}
