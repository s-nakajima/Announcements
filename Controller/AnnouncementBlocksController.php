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
	public $layout = 'Frames.setting';

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Blocks.Block',
	);

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
 * @throws Exception
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

		try {
			$announcements = $this->Paginator->paginate('Announcement');
		} catch (Exception $ex) {
			if (isset($this->request['paging']) && $this->params['named']) {
				$this->redirect('/announcements/announcement_blocks/index/' . $this->viewVars['frameId']);
				return;
			}
			CakeLog::error($ex);
			throw $ex;
		}

		if (! $announcements) {
			$this->view = 'AnnouncementBlocks/not_found';
			return;
		}

		$results = array(
			'announcements' => $announcements
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		$this->set('blockId', null);
		$announcement = $this->Announcement->create(
			array(
				'id' => null,
				'key' => null,
				'block_id' => null,
				'status' => null,
			)
		);
		$block = $this->Block->create(
			array('id' => null, 'key' => null)
		);

		$data = array();
		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();

			$this->Announcement->saveAnnouncement($data);
			if ($this->handleValidationError($this->Announcement->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/announcements/announcement_blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}

			$data['Block']['id'] = null;
			$data['Block']['key'] = null;
			$data['Announcement']['status'] = null;
			unset($data['Frame']);
		}
		$data = Hash::merge($announcement, $block, $data);
		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		if (! $this->__initAnnouncement()) {
			return;
		}

		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();

			$data['Announcement']['key'] = $this->viewVars['announcement']['key'];
			unset($data['Announcement']['id']);

			$this->Announcement->saveAnnouncement($data);
			if ($this->handleValidationError($this->Announcement->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/announcements/announcement_blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}

			$data['Announcement']['status'] = $this->viewVars['announcement']['status'];
			unset($data['Frame']);
			$results = $this->camelizeKeyRecursive($data);
			$this->set($results);
		}
	}

/**
 * delete
 *
 * @throws BadRequestException
 * @return void
 */
	public function delete() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		if (! $this->__initAnnouncement()) {
			return;
		}

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
 * initAnnouncement
 *
 * @return bool True on success, False on failure
 */
	private function __initAnnouncement() {
		if ($this->viewVars['blockId']) {
			if (! $announcement = $this->Announcement->getAnnouncement(
					$this->viewVars['blockId'],
					$this->viewVars['roomId'],
					$this->viewVars['contentEditable']
			)) {
				$this->throwBadRequest();
				return false;
			}
			$announcement = $this->camelizeKeyRecursive($announcement);
			$this->set($announcement);
		}

		return true;
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
		$data['Announcement']['is_auto_translated'] = true;
		$data['Announcement']['is_first_auto_translation'] = true;
		$data['Announcement']['translation_engine'] = '';

		if ($data['Block']['public_type'] === Block::TYPE_LIMITED) {
			//$data['Block']['from'] = implode('-', $data['Block']['from']);
			//$data['Block']['to'] = implode('-', $data['Block']['to']);
		} else {
			unset($data['Block']['from'], $data['Block']['to']);
		}

		return $data;
	}

}
