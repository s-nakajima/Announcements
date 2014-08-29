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
 * components
 * @var array
 */
	public $components = array(
		'Security',
	);

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
		'Announcements.AnnouncementPartSetting',
		'Announcements.AnnouncementSetting',
		'Announcements.AnnouncementsBlock',
	);

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
		if (! $frameId ||
		! $this->_initializeFrame($frameId, $lang)) {
			return $this->render(false);
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
		$data = $this->Announcement->getLatestContent($this->viewVars['blockId'], $this->viewVars['langId']);
		$this->set('item', $data);
		if (! Configure::read('Pages.isSetting')) {
			return $this->render('Announcements/view/editor');
		}
		//$blockPart = $this->AnnouncementBlockPart->getListPartIdArray($this->blockId);
		$blockPart = array();
		$this->set('blockPart', $blockPart);
		return $this->render('Announcements/setting/index');
	}

/**
 * index not login
 *
 * @return CakeResponse
 */
	private function __view() {
		$data = $this->Announcement->getPublishContent($this->viewVars['blockId'], $this->viewVars['langId']);
		if (! $data) {
			return $this->render(false);
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
			return $this->_renderJson(400, __d('announcements', 'I failed to save'));
		}
		//準備
		$this->_initializeFrame($frameId);
		if (! $this->viewVars['contentEditable']) {
			//権限エラー
			return $this->_renderJson(403, __d('announcements', 'I failed to save'));
		}
		//保存
		$rtn = $this->Announcement->saveContent(
			$this->data,
			$frameId,
			$this->viewVars['blockId'],
			true
		);
		//成功結果を返す
		if (!$rtn) {
			//失敗結果を返す
			return $this->_renderJson(500, __d('announcements', 'I failed to save'), $rtn);
		}
		$rtn['Announcement']['content'] = rawurlencode($rtn['Announcement']['content']);
		return $this->_renderJson(200, __d('announcements', 'Saved'), $rtn);
	}

/**
 * お知らせ投稿用のformを取得する
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function form($frameId = 0) {
		$this->layout = false;
		$this->_initializeFrame($frameId);
		return $this->render('Announcements/setting/form');
	}

}