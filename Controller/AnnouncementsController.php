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
		'NetCommons.NetCommonsFrame' => array(
			'setView' => true
		),
		'NetCommons.NetCommonsRoomRole' => array(
			'setView' => true,
			'workflowActions' => array('edit'),
			'workflowModelName' => 'Announcement',
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
 * beforeFilter
 *
 * @return void
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
		//TODO: 認証チェック
		//$this->Auth->unauthorizedRedirect = false;
		//$this->Auth->ajaxLogin = true;
		//$this->Auth->ajaxLayout = false;
		//$this->Auth->loginAction = null;
		//CakeLog::debug(get_class($this) . '.' . $this->params['action'] . '.beforeFilter');
		//CakeLog::debug(print_r($this->Session->read('Auth.redirect'), true));
		//$this->Auth->loginAction = array(
		//		'plugin' => 'auth',
		//		'controller' => 'auth',
		//		'action' => null,
		//	);
		//$this->Auth->deny(array('edit', 'setting'));
		//$this->Auth->allow('view', 'index');
		//$this->Auth->allow();


		//Frameのデータをviewにセット
		//$frameId = (isset($this->params['pass'][0]) ? (int)$this->params['pass'][0] : 0);
		//$this->NetCommonsFrame->setView($this, $frameId);

		//var_dump($this->params);
		//Roleのデータをviewにセット
		//$this->NetCommonsRoomRole->setView($this);
		$this->NetCommonsRoomRole->allow(
			array('contentEditable' => array('setting', 'token', 'edit'))
		);
	}
/**
 * The beforeRedirect method is invoked when the controller's redirect method is called but before any
 * further action.
 *
 * If this method returns false the controller will not continue on to redirect the request.
 * The $url, $status and $exit variables have same meaning as for the controller's method. You can also
 * return a string which will be interpreted as the URL to redirect to or return associative array with
 * key 'url' and optionally 'status' and 'exit'.
 *
 * @param string|array $url A string or array-based URL pointing to another location within the app,
 *     or an absolute URL
 * @param integer $status Optional HTTP status code (eg: 404)
 * @param boolean $exit If true, exit() will be called after the redirect
 * @return mixed
 *   false to stop redirection event,
 *   string controllers a new redirection URL or
 *   array with the keys url, status and exit to be used by the redirect method.
 * @link http://book.cakephp.org/2.0/en/controllers.html#request-life-cycle-callbacks
 */
	public function beforeRedirect($url, $status = null, $exit = true) {
//		CakeLog::debug(get_class($this) . '.' . $this->params['action'] . '.beforeRedirect');
//		CakeLog::debug(print_r($this->Session->read('Auth.redirect'), true));
//		CakeLog::debug($this->response->statusCode());
//		CakeLog::debug($status);
//		CakeLog::debug(print_r($url, true));
//		CakeLog::debug(print_r($this->Auth->authError, true));
//		if ($this->Session->read('Auth.redirect')) {
//			$this->Session->delete('Auth.redirect');
//			throw new UnauthorizedException(__d('net_commons', 'Unauthorized'));
//		}
//$this->response->statusCode(200);
//		return parent::beforeRedirect($url, 200, $exit);
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
			if (! $this->Announcement->saveAnnouncement($this->data)) {
				//バリデーションエラー
				$results = array('validationErrors' => $this->Announcement->validationErrors);
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

}
