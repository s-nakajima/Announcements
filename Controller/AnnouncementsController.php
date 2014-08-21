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
 * セッティングモードの状態
 *
 * @var bool
 */
	public $isSetting = false;

/**
 * Announcement model object
 *
 * @var null
 */
	public $Announcement = null;

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
		//初期値
		$this->set('item', array());
		$this->set('draftItem', array());
		//ユーザIDの取得と設定
		$this->_setLoginUserId();
		//言語設定
		$this->_setLang();
		$this->setLayout(); //レイアウトきりかえ
	}

/**
 * index
 *
 * @param int $frameId frames.id
 * @param string $lang 言語設定 2文字
 * @return CakeResponse
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function index($frameId = 0, $lang = '') {
		$this->_setLang($lang);
		$this->_setFrame($frameId); //flameの確認
		$this->setPartList(); //パートの一覧取得

		//ブロックが設定されておらず、セッティングモードでもない
		if (! $this->blockId && ! $this->isSetting) {
			return $this->render('notice');
		}
		//編集権限が無い人 (ログイン中も含む 公開情報しかみえない）
		if (! $this->isEdit
			&& ! $this->isBlockEdit
			&& ! $this->isSetting) {
			//blockから情報を取得 $LangId
			return $this->__indexNologin($this->frameId, $this->blockId);
		}
		//セッティングモードではないが、編集権限はある
		if ($this->isEdit
				&& ! $this->isSetting) {
			return $this->__indexNoSetting($this->frameId, $this->blockId);
		}
		//ブロックの編集権限あり (ルーム管理者を含む）
		if ($this->isEdit) {
			return $this->__indexEdit();
		}
		//セッティングモードon 編集権限のみ
		return $this->render("Announcements/setting/index");
	}

/**
 * セッティングモードON ブロック編集権限が有る場合
 *
 * @return mixed
 */
	private function __indexEdit() {
		if (! $this->isRoomAdmin) {
			//セッティングモードON 編集権限がある
			$draftData = $this->AnnouncementDatum->getData($this->blockId, $this->langId, true);
			//セッティングモードOFF データ無し(下書きもなし）
			$data = $this->AnnouncementDatum->getData($this->blockId, $this->langId, $this->isSetting);
			$this->set('draftItem', $draftData);
			$this->set('item', $data);
			return $this->render("Announcements/setting/index");
		}

		//セッティングモードON 編集権限がある
		$draftData = $this->AnnouncementDatum->getData($this->blockId, $this->langId, true);
		//セッティングモードOFF データ無し(下書きもなし）
		$data = $this->AnnouncementDatum->getData($this->blockId, $this->langId, $this->isSetting);
		if (! $data
			&& ! $draftData
			&& $this->frameId
			&& ! $this->blockId
			&& $this->isBlockEdit
		) {
			//コンテンツも無く、blockもなく、でもプラグインだけが設置されている状態
			//もうこの状態でblockを新規作成してしまう。 そうするとblockIdがないviewの状態を防げる。
			//frameIdがあり、frames.block_idがなくedit_blockの権限がある状態
			//frameにblockを作成する。
			$this->Frame->createBlock($this->frameId, $this->userId);
			//設定値を再格納
			$this->NetCommonsPlugin->setFrameId($this->frameId);
		}
		$this->set('draftItem', $draftData);
		$this->set('item', $data);

		$blockPart = $this->AnnouncementBlockPart->getListPartIdArray($this->blockId);
		$this->set('blockPart', $blockPart);
		$messagePart = array();
		$publicMessage = array();
		$updateMessage = array();
		$this->set('messagePart', $messagePart);
		$this->set('publicMessage', $publicMessage);
		$this->set('updateMessage', $updateMessage);
		return $this->render("Announcements/setting/index");
	}

/**
 * index セッティングモードOFF 書き込み権限有り
 *
 * @return CakeResponse
 */
	private function __indexNoSetting() {
		$data = $this->AnnouncementDatum->getData($this->blockId, $this->langId, true);
		if (! $data) {
			return $this->render("notice");
		}
		$this->set('item', $data);
		return $this->render("Announcements/index/editor");
	}

/**
 * index 未ログイン向け処理
 *
 * @return CakeResponse
 */
	private function __indexNologin() {
		$data = $this->AnnouncementDatum->getPublishData($this->blockId, $this->langId);
		if (! $data) {
			return $this->render("notice");
		}
		$this->set('item', $data);
		return $this->render("Announcements/index/default");
	}

/**
 * お知らせの保存処理実行
 *
 * @param int $frameId frames.id
 * @return CakeResponse
 */
	public function edit($frameId = 0) {
		$this->_setFrame($frameId);
		$this->viewClass = 'Json';
		$this->layout = false;
		if (! $this->request->isPost()) {
			return $this->__ajaxPostError();
		}
		//保存
		$rtn = $this->AnnouncementDatum->saveData(
			$this->data,
			$this->frameId,
			$this->userId,
			$this->request->is('ajax')
		);
		//成功結果を返す
		if ($rtn) {
			//urlEncode
			$rtn['AnnouncementDatum']['content'] = rawurlencode($rtn['AnnouncementDatum']['content']);
			$result = array(
				'status' => 'success',
				'message' => __('保存しました'),
				'data' => $rtn
			);
			$this->set(compact('result'));
			$this->set('_serialize', 'result');
			return $this->render();
		}
		//失敗結果を返す
		$this->response->statusCode(500);
		$result = array(
			'status' => 'error',
			'message' => __('保存に失敗しました'),
			'data' => $rtn
		);
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
		return $this->render();
	}

/**
 * post以外でrequestされた場合のエラー出力
 *
 * @return CakeResponse
 */
	private function __ajaxPostError() {
		//post以外の場合、エラー
			$this->response->statusCode(400);
			$result = array(
				'message' => __('登録できません'),
			);
			$this->set(compact('result'));
			$this->set('_serialize', 'result');
			return $this->render();
	}

/**
 * 新規作成処理(非同期通信）
 * add
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function add($frameId) {
		return $this->edit($frameId);
	}

/**
 * お知らせ投稿用のformを取得する
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function form($frameId = 0) {
		$this->_setFrame($frameId);
		$this->layout = false;
		return $this->render("Announcements/setting/get_edit_form");
	}
}