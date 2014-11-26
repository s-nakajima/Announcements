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
		'NetCommons.NetCommonsRoomRole',
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
 * beforeFilter
 *
 * @return void
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
		//TODO: 認証チェック
		//$this->Auth->unauthorizedRedirect = false;
		//$this->Auth->loginAction = false;
		//$this->Auth->deny(array('edit', 'setting'));
		//$this->Auth->allow('view', 'index');
		$this->Auth->allow();

		//TODO: 権限チェック(NetCommonsAuthコンポーネント)もallow

		//Frameのデータをviewにセット
		$frameId = (isset($this->params['pass'][0]) ? (int)$this->params['pass'][0] : 0);
		$this->NetCommonsFrame->setView($this, $frameId);

		//Roleのデータをviewにセット
		$this->NetCommonsRoomRole->setView($this);
	}

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
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);

		//Announcementデータをviewにセット
		$this->set('announcement', $announcement);
		if (! $announcement) {
			//TODO: autoRender= false
			$this->render(false);
		}
	}

/**
 * setting method
 *
 * @return void
 */
	public function setting() {
		//編集権限チェック
		$this->__validateEditable();

		$this->layout = 'NetCommons.modal';
		$this->view();
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		//編集権限チェック
		$this->__validateEditable();

		//登録処理
		if ($this->request->isPost()) {
			//公開権限チェック
			$this->__validatePublishable();

			//登録
			if (! $this->Announcement->saveAnnouncement($this->data)) {
				//バリデーションエラー
				$results = array('validationErrors' => $this->Announcement->validationErrors);
				//TODO: ステータスコード定数？
				$this->renderJson($results, __d('net_commons', 'Bad Request'), 400);
				return;
			}
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
		//編集権限チェック
		$this->__validateEditable();

		$this->view();
		$this->render('Announcements/token', false);
	}

/**
 * __validateEditable method
 *
 * @return void
 * @throws UnauthorizedException
 * @throws ForbiddenException
 */
	private function __validateEditable() {
		//認証エラー
		//TODO: Auth->allowでやる
		if (! $this->Auth->user()) {
			throw new UnauthorizedException(__d('net_commons', 'Unauthorized'));
		}
		//編集権限チェック
		//TODO: コンポーネント化
		if (! $this->viewVars['contentEditable']) {
			//TODO: Permission denied
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}
	}

/**
 * __validatePublishable method
 *
 * @return void
 * @throws ForbiddenException
 */
	private function __validatePublishable() {
		//公開権限チェック
		if (! isset($this->data['Announcement']['status'])) {
			//TODO: Invalid request
			//TODO: Bad request
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

		//TODO: モデル名？を渡して共通化(NetCommonsAuth)
		if (! $this->viewVars['contentPublishable'] && (
				$this->data['Announcement']['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED ||
				$this->data['Announcement']['status'] === NetCommonsBlockComponent::STATUS_DISAPPROVED
			)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}
	}

}
