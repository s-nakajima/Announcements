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
		'Paginator'
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

		//Frameのデータをviewにセット
		$frameId = (int)$this->params['pass'][0];
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
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
		//Announcementデータを取得
		$announcement = $this->Announcement->getAnnouncement(
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);

		$this->set('announcement', $announcement);
		if ($this->params['action'] === 'view' || $this->params['action'] === 'index') {
			//HTMLで出力
			$this->viewClass = 'View';
			$this->response->type('html');
			return $this->render('AnnouncementEdit/view', false);
		}
	}

/**
 * view latest
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 * @throws ForbiddenException
 */
	public function view_latest($frameId = 0) {
		//最新データ取得
		$this->view($frameId);
		$this->comment($frameId);

		return $this->render('AnnouncementEdit/view_latest', false);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 * @throws ForbiddenException
 */
	public function comment($frameId = 0) {
		//コメントデータを取得
		$this->Announcement->unbindModel(array('belongsTo' => array('Block')), false);
		$this->Paginator->settings = array(
			'Announcement' => array(
				'fields' => array(
					'Announcement.id',
					'Announcement.comment',
					'Announcement.created_user',
					'Announcement.created',
					'CreatedUser.key',
					'CreatedUser.value',
				),
				'conditions' => array(
					'Announcement.block_id' => $this->viewVars['blockId'],
					'Announcement.comment !=' => '',
				),
				'limit' => 5,
				'order' => 'Announcement.id DESC',
			),
			'CreatedUser' => array(
				'conditions' => array(
					'Announcement.created_user = CreatedUser.user_id',
					'CreatedUser.language_id' => $this->viewVars['languageId'],
					'CreatedUser.key' => 'nickname'
				)
			)
		);
		$comments = $this->Paginator->paginate('Announcement');
		$this->Announcement->bindModel(array('belongsTo' => array('Block')), false);
		$this->set('comments', $comments);

		if ($this->params['action'] === 'comment') {
			return $this->render('AnnouncementEdit/comment', false);
		}
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0) {
		$this->view($frameId);

		//HTMLで出力
		$this->viewClass = 'View';
		$this->response->type('html');
		return $this->render('AnnouncementEdit/form', false);
	}

/**
 * post method
 *
 * @param int $frameId frames.id
 * @return string JSON that indicates success
 * @throws ForbiddenException
 */
	public function edit($frameId = 0) {
		//POSTチェック
		if (! $this->request->isPost()) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

		//入力チェック
		$this->Announcement->set($this->request->data);
		$validateFileds = array(
			'fieldList' => array('content', 'comment')
		);
		if (! $this->Announcement->validates($validateFileds)) {
			$this->response->statusCode(403);
			$errors = $this->Announcement->invalidFields();
			$keys = array_keys($errors);
			foreach ($keys as $key) {
				$errors[$key] = array_unique($errors[$key]);
			}
			$result = array(
				'name' => __d('net_commons', 'Validation errors'),
				'errors' => $errors
			);
			$this->set(compact('result'));
			$this->set('_serialize', 'result');
			return $this->render(false);
		}

		//登録
		$result = $this->Announcement->saveAnnouncement($this->data);
		if (! $result) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

		//最新データ取得
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
