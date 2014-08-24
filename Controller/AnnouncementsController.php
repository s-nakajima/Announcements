<?php
/**
 * Announcements Controller
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AppController', 'Controller');
App::uses('AnnouncementsAppController', 'Announcements.Controller');

class AnnouncementsController extends AnnouncementsAppController {

/**
 * 準備
 *
 * @return void
 */
	public function beforeFilter() {
		//親処理
		parent::beforeFilter();
		//未ログインでもアクセスを許可
		$this->Auth->allow();
		//言語ID初期値を格納
		$this->set('langId', $this->langId);
	}

/**
 * index
 *
 * @param int $frameId frames.id
 * @param string $lang language
 * @return CakeResponse
 */
	public function index($frameId = 0, $lang = '') {
		return $this->view($frameId, $lang);
	}

/**
 * view content detail
 *
 * @param int $frameId frames.id
 * @param string $lang language
 * @return CakeResponse
 */
	public function view($frameId = 0, $lang = '') {
		$this->_contentPreparation($frameId, $lang);

		if (! $frameId) {
			return $this->render('notice');
		}
		//ログインしていない 編集権限がない
		if (! CakeSession::read('Auth.User.id') ||
			! $this->viewVars['contentEditable']
		) {
			return $this->__view();
		}
		//編集権限がある
		return $this->__viewEdit();
	}

/**
 * セッティングモードON ブロック編集権限が有る場合
 *
 * @return mixed
 */
	private function __viewEdit() {
		//セッティングモード
		$data = $this->Announcement->get($this->viewVars['blockId'], $this->langId);
		$this->set('item', $data);
		if (! Configure::read('Pages.isSetting')) {
			return $this->render("Announcements/view/editor");
		}
		//$blockPart = $this->AnnouncementBlockPart->getListPartIdArray($this->blockId);
		$blockPart = array();
		$this->set('blockPart', $blockPart);
		return $this->render("Announcements/setting/index");
	}

/**
 * index not login
 *
 * @return CakeResponse
 */
	private function __view() {
		$data = $this->Announcement->get($this->viewVars['blockId'], $this->langId, true);
		if (! $data) {
			return $this->render("notice");
		}
		$this->set('item', $data);
		return $this->render('Announcements/view/default');
	}

/**
 * お知らせの保存処理実行
 *
 * @param int $frameId frames.id
 * @return CakeResponse
 */
	public function edit($frameId = 0) {
		if (! $this->request->isPost()) {
			return $this->__ajaxMessage(400, __('I failed to save'));
		}
		//準備
		$this->_contentPreparation($frameId);
		if (!$this->viewVars['contentEditable']) {
			//権限エラー
			return $this->__ajaxMessage(403, __('I failed to save'));
		}

		//保存
		$rtn = $this->Announcement->saveContent(
			$this->data,
			$this->viewVars['frameId'],
			$this->viewVars['blockId'],
			true
		);
		//成功結果を返す
		if (!$rtn) {
			//失敗結果を返す
			return $this->__ajaxMessage(500, __('I failed to save'), $rtn);
		}
		$rtn['Announcement']['content'] = rawurlencode($rtn['Announcement']['content']);
		return $this->__ajaxMessage(200, __('Saved'), $rtn);
	}

/**
 * ajax message output
 *
 * @param int $code status code
 * @param string $message message
 * @param array $data updated content data
 * @return CakeResponse
 */
	private function __ajaxMessage($code, $message, $data = "") {
		$this->viewClass = 'Json';
		$this->layout = false;
		$this->view = null;
		//post以外の場合、エラー
		$this->response->statusCode($code);
		$result = array(
			'message' => $message,
			'data' => $data
		);
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
		return $this->render();
	}

/**
 * お知らせ投稿用のformを取得する
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function form($frameId = 0) {
		$this->layout = false;
		$this->_contentPreparation($frameId);
		return $this->render("Announcements/setting/form");
	}

/**
 *  Content Preparation
 *
 * @param int $frameId frames.id
 * @param string $lang language
 * @return bool
 */
	protected function _contentPreparation($frameId, $lang = "") {
		$frame = $frame = $this->Frame->findById($frameId);
		$this->set('frameId', 0);
		$this->set('blockId', 0);
		$this->set('roomId', 0);
		$this->set('roomId', 0);
		$this->set('needApproval', true);
		$this->set('isRoomAdmin', false);
		$this->set('blockEditable', false);
		$this->set('blockPublishable', false);
		$this->set('contentEditable', false);
		$this->set('contentPublishable', false);

		if ($frame &&
			isset($frame[$this->Frame->name]['id']) &&
			isset($frame[$this->Frame->name]['room_id'])) {
			$frame = $frame[$this->Frame->name];
			$this->set('frameId', $frame['id']);
			$this->set('blockId', $frame['block_id']);
			$this->set('roomId', $frame['room_id']);

			if (CakeSession::read('Auth.User.id')) {
				$this->set('needApproval', true);
				$this->set('isRoomAdmin', true);
				$this->set('blockEditable', true);
				$this->set('blockPublishable', true);
				$this->set('contentEditable', true);
				$this->set('contentPublishable', true);
			}

			//パート一覧取得
			$partList = $this->LanguagesPart->find('all',
				array('conditions' => array(
					$this->LanguagesPart->name . '.language_id' => $this->langId
				)));
			$this->set('partList', $partList);
		}
	}
}