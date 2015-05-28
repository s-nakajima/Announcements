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
		'NetCommons.NetCommonsWorkflow',
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

		if ($this->request->is('ajax')) {
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
 * @return void
 */
	public function edit() {
		$this->__initAnnouncement(['comments']);

		if ($this->request->isPost()) {
			if (!$status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}

			$data = Hash::merge(
				$this->data, [
					'Announcement' => [
						'status' => $status,
						'is_active' => true,
						'is_latest' => true,
						'is_auto_translated' => true,
						'is_first_auto_translation' => true,
						'translation_engine' => 'microsoft',
					]
				]
			);
			$this->Announcement->setDataSource('master');
			if (!$announcement = $this->Announcement->getAnnouncement(
				isset($data['Block']['id']) ? (int)$data['Block']['id'] : null,
				true
			)) {
				$announcement = $this->Announcement->create(['key' => Security::hash('announcement' . mt_rand() . microtime(), 'md5')]);
			}

			$data = Hash::merge($announcement, $data);
			$announcement = $this->Announcement->saveAnnouncement($data);
			if (!$this->handleValidationError($this->Announcement->validationErrors)) {
				$results = $this->camelizeKeyRecursive($this->Announcement->data);
				$this->set([
					'announcements' => $results['announcement'],
				]);
				return;
			}
			$this->set('blockId', $announcement['Announcement']['block_id']);
			$this->redirectByFrameId();
			return;
		}
	}

/**
 * Initialize announcement related data
 *
 * @param array $contains Optional result sets
 * @return void
 */
	private function __initAnnouncement($contains = []) {
		if (!$announcements = $this->Announcement->getAnnouncement(
			$this->viewVars['blockId'],
			$this->viewVars['contentEditable']
		)) {
			$announcements = $this->Announcement->create();
		}
		$results = array(
			'announcements' => $announcements['Announcement'],
			'contentStatus' => $announcements['Announcement']['status'],
		);

		if (in_array('comments', $contains, true)) {
			$results['comments'] = $this->Comment->getComments(
				array(
					'plugin_key' => 'announcements',
					'content_key' => isset($announcements['Announcement']['key']) ? $announcements['Announcement']['key'] : null,
				)
			);
		}

		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}
}
