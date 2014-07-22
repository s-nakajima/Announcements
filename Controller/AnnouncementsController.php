<?php
/**
 * Announcements Controller
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
App::uses(
	'AnnouncementsAppController',
	'Announcements.Controller'
);

class AnnouncementsController extends AnnouncementsAppController {

/**
 * 使用するコンポーネント
 *
 * @var array
 */
	public $components = array(
		'Security',
		'RequestHandler'
	);

/**
 * セッティングモードの状態
 *
 * @var bool
 */
	private $__isSetting = false;

/**
 * 非同期通信の判定結果
 *
 * @var bool
 */
	private $__isAjax = false;

/**
 * 編集権限
 *
 * @var bool
 */
	private $__isEditer = false;

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
 * 言語一覧
 *
 * @var array
 */
	public $langList = array();

/**
 * user id
 *
 * @var int
 */
	private $__userId = 0;

/**
 * isBlockEditer room_parts.edit_block
 *
 * @var bool
 */
	private $__BlockEditer = false;

/**
 * 準備
 *
 * @return void
 */
	public function beforeFilter() {
		//親処理
		parent::beforeFilter();
		$this->Auth->allow();
		//modelのセット
		$this->AnnouncementDatum = Classregistry::init("Announcements.AnnouncementDatum");
		//設定値の格納 (セッティングモード判定結果）
		$this->__isSetting = Configure::read('Pages.isSetting');
		$this->Frame = Classregistry::init("Announcements.AnnouncementFrame");
		//初期値
		$this->set('blockId', 0);

		//ユーザIDの設定
		$this->__setUserId();
		//編集権限のチェックと設定値の格納
		$this->__checkEditer();
		//ルーム管理者判定
		$this->__checkRoomAdmin();
		//著者かどうかの確認と設定値の格納
		$this->__checkAuthor();
		//Ajax判定と設定値の格納
		$this->__checkAjax();
		//言語設定
		$this->__setLang();
		//ブロックの編集権限の確認と設定
		$this->__setBlockEditer();
	}

/**
 * index
 *
 * @param int $frameId frames.id
 * @return CakeResponse
 */
	public function index($frameId = 0) {
		//レイアウトきりかえ
		$this->__setLayout();
		$this->__setFrame($frameId);
		$this->__setCheckPart();
		$this->__setPartList();

		$this->set('item', array());
		//blockIdの取得
		$blockId = $this->Frame->getBlockId($frameId);

		//ブロックが設定されておらず、セッティングモードでもない
		if (! $blockId && ! $this->__isSetting) {
			return $this->render('notice');
		}

		//編集権限が無い人 (ログイン中も含む 公開情報しかみえない）
		if (! $this->__isEditer ) {
				//blockから情報を取得 $LangId
				return $this->__indexNologin($frameId, $blockId);
		}

		//セッティングモードではないが、編集権限はある
		if (! $this->__isSetting && $this->__isEditer) {
			return $this->__indexNoSetting($frameId, $blockId);
		}

		//セッティングモードON 編集権限がある
		$draftData = $this->AnnouncementDatum->getData($blockId, $this->langId, true);
		//セッティングモードOFF データ無し(下書きもなし）
		$data = $this->AnnouncementDatum->getData($blockId, $this->langId, $this->__isSetting);
		if (! $data && ! $this->__isSetting && !$draftData) {
			return $this->render('notice');
		}
		$this->set('draftItem', $draftData);
		$this->set('item', $data);
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);
		//出力
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
		return $this->render("Announcements/index/editer");
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
			$this->__userId,
			$this->__isAjax
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
		$result = array(
			'status' => 'NG',
			'message' => __('保存に失敗しました')
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
 *
 * @param string $type 情報のタイプ
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @param int $dataId  announcement_data.id
 * @return void
 */
	public function add($type, $frameId = 0, $blockId = 0, $dataId = 0) {
		$this->post($type, $frameId, $blockId, $dataId);
	}

/**
 * 削除(非同期通信）
 *
 * @param string $type 情報のタイプ
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @param int $dataId  announcement_data.id
 * @return void
 */
	public function delete($type, $frameId = 0, $blockId = 0, $dataId = 0) {
	}

/**
 * お知らせ投稿用のformを取得する
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return void
 */
	public function get_edit_form($frameId = 0, $blockId = 0) {
		$this->layout = false;
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);
		return $this->render("Announcements/setting/get_edit_form");
	}

/**
 * 編集権源の設定
 *
 * @return bool
 */
	private function __checkEditer() {
		if (! $this->Auth->loggedIn()) {
			$this->__isEditer = false;
			$this->set('isEdit', false);
			return false;
		}
		$this->__isEditer = true;
		$this->set('isEdit', true);
		return true;
	}

/**
 * ルーム管理者判定
 *
 * @return void
 */
	private function __checkRoomAdmin() {
		$this->set('isAdmin', true);
	}

/**
 * 書いた人設定
 *
 * @return void
 */
	private function __checkAuthor() {
		$this->set('isAuthor', true);
	}

/**
 * 非同期通信の場合、レイアウトなし設定をする。
 *
 * @return void
 */
	private function __setLayout() {
		if ($this->__isAjax) {
			$this->layout = false;
		}
	}

/**
 * 非同期通設定
 *
 * @return void
 */
	private function __checkAjax() {
		if ($this->request->is('ajax')) {
			$this->__isAjax = 1;
		}
	}

/**
 * 言語一覧の設定
 *
 * @return void
 */
	private function __setLang() {
		//本来はDBより取得
		$this->langList = array(
			1 => 'en',
			2 => 'ja'
		);
		$this->langId = 2;
		$this->set('langId', $this->langId);
	}

/**
 * user_idの設定
 *
 * @return void
 */
	private function __setUserId() {
		if ($this->Auth->loggedIn()) {
			$this->__userId = 1;
			$this->Set('isLogin', true);
		}
		$this->__userId = 1;
		$this->Set('isLogin', false);
	}

/**
 * ブロックに対する編集権限
 *
 * @return void
 */
	private function __setBlockEditer() {
		$this->__BlockEditer = true;
		$this->Set('isBlockEditer', $this->__BlockEditer);
	}

/**
 * frame 取得とそこからの諸々設定
 *
 * @param int $frameId flames.id
 * @return mixed
 */
	private function __setFrame($frameId) {
		return $this->_setFrame($frameId);
	}

/**
 * 操作している人の権限の確認
 * blockのedit権限、ルーム管理者
 *
 * @return void
 */
	private function __setCheckPart() {
		//ルーム管理者
		$this->isRoomAdmin = true;
		$this->set("isRoomAdmin", $this->isRoomAdmin);
		//ブロックの編集権限
		$this->set('isBlockEditer', true);
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
		return $rtn;
	}

}