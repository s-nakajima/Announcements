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
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock', //Use Announcement model
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole' => array(
			'workflowActions' => array('edit'),
			'workflowModelName' => 'Announcement',
			'allowedActions' => array(
				'contentEditable' => array('setting', 'token', 'edit')
			)
		),
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsForm'
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->view();
		if ($this->viewVars['announcement']) {
			$this->render('Announcements/view');
		}
	}

/**
 * view method
 *
 * @return void
 */
	public function view() {
		//Announcementデータを取得
		$announcement = $this->Announcement->getAnnouncement(
				$this->viewVars['frameId'],
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);

		//Announcementデータをviewにセット
		$this->set('announcement', $announcement);
		if (! $announcement) {
			$this->autoRender = false;
		}
	}

/**
 * setting method
 *
 * @return void
 */
	public function setting() {
		$this->layout = 'NetCommons.modal';
		$this->view();
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		//登録処理
		if ($this->request->isPost()) {
			//登録
			$announcement = $this->Announcement->saveAnnouncement($this->data);
			if (! $announcement) {
				//バリデーションエラー
				$results = array('validationErrors' => $this->Announcement->validationErrors);
				$this->renderJson($results, __d('net_commons', 'Bad Request'), 400);
				return;
			}
			$this->set('blockId', $announcement['Announcement']['block_id']);
		}

		//最新データ取得
		$this->view();

		//render
		if ($this->request->isPost()) {
			//登録後のrender
			$results = array('announcement' => $this->viewVars['announcement']);
			$this->renderJson($results, __d('net_commons', 'Successfully finished.'));

		} else {
			//コメントデータ取得
			//TODO: contentKeyが空の場合、全件表示されてしまう。
			$contentKey = $this->viewVars['announcement']['Announcement']['key'];
			$view = $this->requestAction(
					'/comments/comments/index/announcements/' . $contentKey . '.json', array('return'));
			$comments = json_decode($view, true);
			//JSON形式で戻す
			$results = Hash::merge($comments['results'], array('announcement' => $this->viewVars['announcement']));
			//表示render
			$this->renderJson($results);
		}
	}

/**
 * token method
 *
 * @return void
 */
	public function token() {
		$this->view();
		$this->render('Announcements/token', false);
	}

}
