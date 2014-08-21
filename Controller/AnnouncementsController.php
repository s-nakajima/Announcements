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
		if (! $frameId) {
			return $this->render('notice');
		}
		$this->_setLang($lang);
		$this->_setFrame($frameId);
		$this->setPartList();
		//ログインしていない
		if (! $this->userId) {
			$this->__indexNologin();
		}
		//権限が無い
		if (! $this->isEdit) {
			return $this->__indexNologin($this->frameId, $this->blockId);
		}
		//編集権限がある
		return $this->__indexEdit();
	}

/**
 * セッティングモードON ブロック編集権限が有る場合
 *
 * @return mixed
 */
	private function __indexEdit() {
		//セッティングモードではない
		if (! $this->isSetting) {
			return $this->__indexNoSetting();
		}
		//セッティングモードだ
		$draftData = $this->AnnouncementDatum->getData($this->blockId, $this->langId, true);
		$data = $this->AnnouncementDatum->getData($this->blockId, $this->langId, $this->isSetting);
		$this->set('draftItem', $draftData);
		$this->set('item', $data);

		$blockPart = $this->AnnouncementBlockPart->getListPartIdArray($this->blockId);
		$this->set('blockPart', $blockPart);
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
		if (! $this->request->isPost()) {
			return $this->__ajaxPostError();
		}
		$this->_setFrame($frameId);
		$this->viewClass = 'Json';
		$this->layout = false;
		/*if (! $this->isEdit) {
			//権限エラー
			$this->response->statusCode(403);
			$result = array(
				'message' => __('権限がありません。'),
			);
			$this->set(compact('result'));
			$this->set('_serialize', 'result');
			return $this->render();
		}
		if (! $this->BlockId) {
			//blockの作成
			$this->NetCommonsFrame->createBlock($this->frameId, $this->userId);
		}*/
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