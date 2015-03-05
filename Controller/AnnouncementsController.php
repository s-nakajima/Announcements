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
		/* 'NetCommons.NetCommonsBlock', */
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
 * @throws NotFoundException
 * @return void
 */
	public function view() {
		$this->__initAnnouncement();

		if ($this->request->is('ajax')) {
			$tokenFields = Hash::flatten($this->request->data);
			$hiddenFields = array(
				'Announcement.block_id',
				'Announcement.key'
			);
			$this->set('tokenFields', $tokenFields);
			$this->set('hiddenFields', $hiddenFields);
			$this->renderJson();
		} else {
			if ($this->viewVars['contentEditable']) {
				$this->view = 'Announcements/viewForEditor';
			}
		}
	}

/**
 * edit method
 *
 * @throws BadRequestException
 * @return void
 */
	public function edit() {
		$this->__initAnnouncement();
		if ($this->request->isGet()) {
			CakeSession::write('backUrl', $this->request->referer());
		}

		if ($this->request->isPost()) {
			if (!$status = $this->__parseStatus()) {
				return;
			}

			$data = Hash::merge(
				$this->data,
				['Announcement' => ['status' => $status]]
			);
			if (!$announcement = $this->Announcement->getAnnouncement(
				(int)$data['Frame']['id'],
				isset($data['Block']['id']) ? (int)$data['Block']['id'] : null,
				true
			)) {
				$announcement = $this->Announcement->create(['key' => Security::hash('announcement' . mt_rand() . microtime(), 'md5')]);
			}

			$data = Hash::merge($announcement, $data);
			$announcement = $this->Announcement->saveAnnouncement($data);
			if (!$this->__handleValidationError($this->Announcement->validationErrors)) {
				return;
			}
			$this->set('blockId', $announcement['Announcement']['block_id']);
			if (!$this->request->is('ajax')) {
				$backUrl = CakeSession::read('backUrl');
				CakeSession::delete('backUrl');
				$this->redirect($backUrl);
			}
			return;
		}
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

/**
 * Parse content status from request
 *
 * @throws BadRequestException
 * @return mixed status on success, false on error
 */
	private function __parseStatus() {
		if ($matches = preg_grep('/^save_\d/', array_keys($this->data))) {
			list(, $status) = explode('_', array_shift($matches));
		} else {
			if ($this->request->is('ajax')) {
				$this->renderJson(
					['error' => ['validationErrors' => ['status' => __d('net_commons', 'Invalid request.')]]],
					__d('net_commons', 'Bad Request'), 400
				);
			} else {
				throw new BadRequestException(__d('net_commons', 'Bad Request'));
			}
			return false;
		}

		return $status;
	}

/**
 * Handle validation error
 *
 * @param array $errors validation errors
 * @return bool true on success, false on error
 */
	private function __handleValidationError($errors) {
		if ($errors) {
			$this->validationErrors = $errors;
			if ($this->request->is('ajax')) {
				$results = ['error' => ['validationErrors' => $errors]];
				$this->renderJson($results, __d('net_commons', 'Bad Request'), 400);
			}
			return false;
		}

		return true;
	}
}
