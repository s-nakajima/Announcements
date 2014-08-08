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
	private $__isSetting = false;

/**
 * model object
 *
 * @var null
 */
	public $AnnouncementDatum = null;

/**
 * Frame model object
 *
 * @var null
 */
	public $Frame = null;

/**
 * Block model object
 *
 * @var null
 */
	public $Block = null;

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
		//modelのセット
		$this->AnnouncementDatum = Classregistry::init("Announcements.AnnouncementDatum");
		//設定値の格納 (セッティングモード判定結果）
		$this->__isSetting = Configure::read('Pages.isSetting');
		$this->set('isSetting', $this->__isSetting);
		$this->Frame = Classregistry::init("Announcements.AnnouncementFrame");
		//初期値
		$this->set('blockId', 0);
		$this->set('isRoomAdmin', false);
		//編集権限初期値
		$this->set('isEdit', false);
		//ブロックの編集権限初期値
		$this->Set('isBlockEdit', false);
		//ユーザIDの取得と設定
		$this->_setLoginUserId();
		//言語設定
		$this->_setLang();
	}

/**
 * index
 *
 * @param int $frameId frames.id
 * @param string $lang 言語設定？
 * @return CakeResponse
 */
	public function index($frameId = 0, $lang = 0) {
		if ($lang) {
			//言語の指定 $langが使用可能か確認する必要がある。
			//Configure::read('Config.language', $lang)
		}

		//レイアウトきりかえ
		$this->__setLayout();
		$this->_setFrame($frameId);
		$this->__setPartList();

		$this->set('item', array());
		//blockIdの取得
		$blockId = $this->Frame->getBlockId($frameId);

		//ブロックが設定されておらず、セッティングモードでもない
		if (! $blockId && ! $this->__isSetting) {
			return $this->render('notice');
		}

		//編集権限が無い人 (ログイン中も含む 公開情報しかみえない）
		if (! $this->isEdit && ! $this->isBlockEdit && ! $this->__isSetting) {
				//blockから情報を取得 $LangId
				return $this->__indexNologin($frameId, $blockId);
		}

		//セッティングモードではないが、編集権限はある
		if (! $this->__isSetting && $this->isEdit) {
			return $this->__indexNoSetting($frameId, $blockId);
		}
		//セッティングモードON 編集権限がある
		$draftData = $this->AnnouncementDatum->getData($blockId, $this->langId, true);
		//セッティングモードOFF データ無し(下書きもなし）
		$data = $this->AnnouncementDatum->getData($blockId, $this->langId, $this->__isSetting);
		$this->set('draftItem', $draftData);
		$this->set('item', $data);
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);
		return $this->render("Announcements/setting/index");
	}

/**
 * index セッティングモードOFF 書き込み権限有り
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return CakeResponse
 */
	private function __indexNoSetting($frameId, $blockId) {
		$data = $this->AnnouncementDatum->getData($blockId, $this->langId, true);
		if (! $data) {
			return $this->render("notice");
		}
		$this->set('item', $data);
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);
		return $this->render("Announcements/index/editor");
	}

/**
 * index 未ログイン向け処理
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return CakeResponse
 */
	private function __indexNologin($frameId, $blockId) {
		$data = $this->AnnouncementDatum->getPublishData($blockId, $this->langId);
		if (! $data) {
			return $this->render("notice");
		}
		$this->set('item', $data);
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);
		return $this->render("Announcements/index/default");
	}

/**
 * お知らせの保存処理実行
 *
 * @param int $frameId frames.id
 * @return CakeResponse
 */
	public function edit($frameId = 0) {
		$this->viewClass = 'Json';
		//レイアウトの設定
		$this->__setLayout();
		if (! $this->request->isPost()) {
			return $this->__ajaxPostError();
		}
		//保存
		$rtn = $this->AnnouncementDatum->saveData(
			$this->data,
			$frameId,
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
				'status' => 'error',
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
 * @param int $blockId blocks.id
 * @return void
 */
	public function form($frameId = 0, $blockId = 0) {
		$this->layout = false;
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);
		return $this->render("Announcements/setting/get_edit_form");
	}

/**
 * 非同期通信の場合、レイアウトなし設定をする。
 *
 * @return void
 */
	private function __setLayout() {
		if ($this->request->is('ajax')) {
			$this->layout = false;
		}
	}

/**
 * パートの取得
 *
 * @return array
 */
	private function __setPartList() {
		//room_partの一覧を取得。setし返す。
		$rtn = $this->AnnouncementRoomPart->getList($this->langId);
		$this->set('partList', $rtn);
		//公開権限の可変リスト
		$abilityName = 'publish_content';
		$publishVariableArray = $this->AnnouncementRoomPart->getVariableListPartIds($abilityName);
		$this->set('publishVariableArray', $publishVariableArray);
		//編集権限の可変リスト
		$abilityName = 'publish_content';
		$editVariableArray = $this->AnnouncementRoomPart->getVariableListPartIds($abilityName);
		$this->set('editVariableArray', $editVariableArray);
		return $rtn;
	}
}