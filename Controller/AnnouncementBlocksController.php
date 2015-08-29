<?php
/**
 * AnnouncementBlocks Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsAppController', 'Announcements.Controller');
App::uses('String', 'Utility');

/**
 * AnnouncementBlocks Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Controller
 */
class AnnouncementBlocksController extends AnnouncementsAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('index', 'add', 'edit', 'delete')
			),
		),
		'Paginator',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Date',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');

		//タブの設定
		$this->initTabs('block_index', 'block_settings');
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'Announcement' => array(
				'order' => array('Announcement.id' => 'desc'),
				'conditions' => array(
					'Block.language_id' => $this->viewVars['languageId'],
					'Block.room_id' => $this->viewVars['roomId'],
					'Block.plugin_key ' => $this->params['plugin'],
					'Announcement.is_latest' => true,
				),
			)
		);

		$announcements = $this->Paginator->paginate('Announcement');
		if (! $announcements) {
			$this->view = 'not_found';
			return;
		}
		$this->set('announcements', $announcements);

		$this->request->data['Frame']['block_id'] = $this->viewVars['blockId'];
		$this->request->data['Frame']['id'] = $this->viewVars['frameId'];
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		$this->set('blockId', null);

		if ($this->request->isPost()) {
			//登録(POST)処理
			$data = $this->__parseRequestData();

			if ($this->Announcement->saveAnnouncement($data)) {
				$this->redirect('/announcements/announcement_blocks/index/' . $this->viewVars['frameId']);
			}
			$this->handleValidationError($this->Announcement->validationErrors);

		} else {
			//初期データセット
			$this->request->data = $this->Announcement->createAnnouncement($this->viewVars['roomId']);
			$this->request->data['Frame'] = array(
				'id' => $this->viewVars['frameId'],
				'key' => $this->viewVars['frameKey']
			);
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! isset($this->params['pass'][1])) {
			$this->throwBadRequest();
			return false;
		}

		if ($this->request->isPut()) {
			$data = $this->__parseRequestData();

			unset($data['Announcement']['id']);

			if ($this->Announcement->saveAnnouncement($data)) {
				$this->redirect('/announcements/announcement_blocks/index/' . $this->viewVars['frameId']);
				return;
			}
			$this->handleValidationError($this->Announcement->validationErrors);

		} else {
			//初期データセット
			$this->request->data = $this->Announcement->getAnnouncement(
				$this->params['pass'][1],
				$this->viewVars['roomId'],
				$this->viewVars['contentEditable'],
				true
			);
			$this->request->data['Frame'] = array(
				'id' => $this->viewVars['frameId'],
				'key' => $this->viewVars['frameKey']
			);
		}

		$comments = $this->Announcement->getCommentsByContentKey($this->request->data['Announcement']['key']);
		$this->set('comments', $comments);
	}

/**
 * delete
 *
 * @throws BadRequestException
 * @return void
 */
	public function delete() {
		if ($this->request->isDelete()) {
			if ($this->Announcement->deleteAnnouncement($this->data)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/announcements/announcement_blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
		}

		$this->throwBadRequest();
	}

/**
 * Parse data from request
 *
 * @return array
 */
	private function __parseRequestData() {
		$data = $this->data;
		if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
			return;
		}
		$data['Announcement']['status'] = $status;

		if ($data['Block']['public_type'] === Block::TYPE_LIMITED) {
			//$data['Block']['from'] = implode('-', $data['Block']['from']);
			//$data['Block']['to'] = implode('-', $data['Block']['to']);
		} else {
			unset($data['Block']['from'], $data['Block']['to']);
		}

		return $data;
	}

}
