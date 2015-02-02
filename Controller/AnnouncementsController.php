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
		'Comments.Comment',
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
				'contentEditable' => array('edit')
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
		$this->__initAnnouncement();

		if (!isset($this->viewVars['announcements'])) {
			throw new NotFoundException(__d('net_commons', 'Not Found'));
		}

		if ($this->request->is('ajax')) {
			$tokenFields = Hash::flatten($this->request->data);
			$hiddenFields = array(
				'Announcement.block_id',
				'Announcement.key'
			);
			$this->set('tokenFields', $tokenFields);
			$this->set('hiddenFields', $hiddenFields);
		}

		/* $results = array( */
		/* 	'announcements' => $this->viewVars['announcements'], */
		/* ); */
		/* $this->set(compact('results')); */

		if ($this->viewVars['contentEditable']) {
			$this->view = 'Announcements/viewForEditor';
		}
		if (! $this->viewVars['announcements']) {
			$this->autoRender = false;
		}
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		//登録処理
		if ($this->request->isPost()) {
			if ($matches = preg_grep('/^save_\d/', array_keys($this->data))) {
				list(, $status) = explode('_', $matches[0]);
			}

			$data = array_merge_recursive(
				$this->data,
				['Announcement' => ['status' => $status]]
			);
			var_dump(1);
			if (!$announcement = $this->Announcement->getAnnouncement(
				(int)$data['Frame']['id'],
				isset($data['Block']['id']) ? (int)$data['Block']['id'] : null,
				true
			)) {
		/* if (!isset($this->data[$this->name]['id']) && !isset($this->data[$this->name]['key'])) { */
		/* 	$this->data[$this->name]['key'] = Security::hash($this->name . mt_rand() . microtime(), 'md5'); */
		/* } */
				$announcement = $this->Announcement->create(['key' => Security::hash('announcement' . mt_rand() . microtime(), 'md5')]);
			}
			var_dump(1);
			/* var_dump($this->request->data); */
			/* var_dump($data); */
			/* var_dump($announcement); */
			/* exit; */
			/* $this->set($data); */
			$announcement = array_merge($announcement['Announcement'], $data['Announcement']);
			var_dump($announcement);
			$ret = $this->Announcement->validateAnnouncement($announcement);
			var_dump($ret);
			if (is_array($ret)) {
				$this->validationErrors = $ret;
				return false;
			}
			var_dump(1);
			$comment = array_merge(
				$this->Announcement->data,
				[
					'Comment' => $data['Comment'],
				]);
			$ret = $this->Comment->validateByStatus($comment, array('caller' => 'Announcement'));
		/* var_dump($comment); */
		/* var_dump($data); */
		/* var_dump($this->Announcement->data); */
		/* var_dump($ret); */
			var_dump(1);
			if (is_array($ret)) {
				$this->validationErrors = $ret;
				return false;
			}

			$announcement = $this->Announcement->saveAnnouncement($data);
			$this->set('blockId', $announcement['Announcement']['block_id']);
			$this->redirect(isset($this->request->query['back_url']) ? $this->request->query['back_url'] : null);
			return;
		}
			var_dump(1);

		//最新データ取得
		$this->__initAnnouncement();
		/* var_dump($this->viewVars); */
		$results = array('announcements' => $this->viewVars['announcements']);
		$this->set('backUrl', isset($this->request->query['back_url']) ? $this->request->query['back_url'] : null);
	}

/**
 * __initAnnouncement method
 *
 * @return void
 */
	private function __initAnnouncement() {
		if (!$announcements = $this->Announcement->getAnnouncement(
			$this->viewVars['frameId'],
			$this->viewVars['blockId'],
			$this->viewVars['contentEditable']
		)) {
			$announcements = $this->Announcement->create();
		}
		$comments = $this->Comment->getComments(
			array(
				'plugin_key' => 'announcements',
				'content_key' => isset($announcements['Announcement']['key']) ? $announcements['Announcement']['key'] : null,
			)
		);

		$results = array(
			'announcements' => $announcements['Announcement'],
			'comments' => $comments,
			'contentStatus' => $announcements['Announcement']['status'],
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}
}
