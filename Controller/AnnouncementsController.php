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
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('setting', 'edit')
			),
		),
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token'
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->view = 'Announcements/view';
		$this->view();
	}

/**
 * view method
 *
 * @return void
 */
	public function view() {
		//Announcementデータを取得
		$this->__setAnnouncement();

		if ($this->viewVars['contentEditable']) {
			$this->view = 'Announcements/viewForEditor';
		}
		if (! $this->viewVars['announcement']) {
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
		$this->__setAnnouncement();
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
			$results = array('announcement' => $announcement);
			$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
			return;
		}

		//最新データ取得
		$this->__setAnnouncement();
		$results = array('announcement' => $this->viewVars['announcement']);

		//コメントデータ取得
		$contentKey = $this->viewVars['announcement']['Announcement']['key'];
		if ($contentKey) {
			$view = $this->requestAction(
					'/comments/comments/index/announcements/' . $contentKey . '.json', array('return'));
			$comments = json_decode($view, true);
			//JSON形式で戻す
			$results = Hash::merge($comments['results'], $results);
		}

		$this->request->data = $this->viewVars['announcement'];
		$tokenFields = Hash::flatten($this->request->data);
		$hiddenFields = array(
			'Announcement.block_id',
			'Announcement.key'
		);
		$this->set('tokenFields', $tokenFields);
		$this->set('hiddenFields', $hiddenFields);
		$this->set('results', $results);
	}

/**
 * __setAnnouncement method
 *
 * @return void
 */
	private function __setAnnouncement() {
		//Announcementデータを取得
		$announcement = $this->Announcement->getAnnouncement(
				$this->viewVars['frameId'],
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);

		//Announcementデータをviewにセット
		$this->set('announcement', $announcement);
	}

}
