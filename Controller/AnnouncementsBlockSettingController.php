<?php
/**
 * AnnouncementsBlockSetting Controller
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
App::uses('AppController', 'Controller');
App::uses('AnnouncementsAppController', 'Announcements.Controller');

class AnnouncementsBlockSettingController extends AnnouncementsAppController {

/**
 * ルーム管理者の承認が必要
 *
 * @var bool
 */
	public $isNeedApproval = true;

/**
 * room admin
 *
 * @var bool
 */
	public $isRoomAdmin = true;

/**
 * 準備
 *
 * @return void
 */
	public function beforeFilter() {
		//親処理
		parent::beforeFilter();
		//user情報の取得
	}

/**
 * パートの取得
 *
 * @return array
 */
	private function __setPartList() {
		//room_partの一覧を取得。setし返す。
		$rtn = $this->AnnouncementRoomPart->getList($this->langId);
		$this->set('partList', $this->AnnouncementRoomPart->getList($this->langId));
		return $rtn;
	}

/**
 * ブロックの編集権限
 *
 * @return void;
 */
	private function __setCheckPart() {
		//ルーム管理者
		$this->isRoomAdmin = true;
		$this->set("isRoomAdmin", $this->isRoomAdmin);
		//ブロックの編集権限
		$this->set('isBlockEditer', true);
	}

/**
 * データ取得
 * 設定なので、offset limitはない。最新の状態
 *
 * @param string $type 取得したいもの
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @param string $dataType データタイプ
 * @return void
 */
	public function view($type, $frameId, $blockId, $dataType = "json") {
		//ルーム管理者の承認が必要なルームかどうかを返す
		//ログインしているユーザのルームパートの取得
		//パート別の公開権限ベースを取得
		//パート別ブロックの公開権限設定を取得
		//パート別ブロックの編集権限ベースを取得
		//パート別ブロックの編集権限設定を取得
	}

/**
 * 更新
 * MEMO : blockIdはpostで受信する
 *
 * @param string $type タイプ
 * @param int $frameId flames.id
 * @return CakeResponse
 * @SuppressWarnings(PHPMD)
 */
	public function edit($type, $frameId) {
		$this->layout = false;
		//postのみ許可
		if (! $this->request->isPost()) {
			return $this->__ajaxError(405, __("POSTのみ操作可能です。"));
		}
		//ブロックの編集権限についてのチェック
		//必須パラメータ
		if (is_numeric($frameId) && $frameId > 0 && $type) {
			if (! $this->_setFrame($frameId)) {
				//該当のframeがない。 404
				return $this->__ajaxError(404, __("指定されたデータは存在しません。"));
			}
			//実行
			if ($type == "publishMessage") {
				return $this->__editPublishMessage($frameId, $this->request->data);
			} elseif ($type == "updateMessage") {
				return $this->__editUpdateMessage($frameId, $this->request->data);
			} elseif ($type == 'publishParts') {
				return $this->__updateBlockParts("publish", $frameId, $this->request->data);
			} elseif ($type == 'editParts') {
				return $this->__updateBlockParts("edit", $frameId, $this->request->data);
			}
		}
		//パラメータエラー:urlに対してなので404で返す
		return $this->__ajaxError(404, __("指定されたデータは存在しません。"));
	}

/**
 * 記事変更通知設定の更新処理
 *
 * @param int $frameId flames.id
 * @param array $data post data
 * @return CakeResponse
 */
	private function __editUpdateMessage($frameId, $data) {
		var_dump($this->data);
		//exit();
	}
/**
 * 公開申請通知設定の更新処理
 *
 * @param int $frameId flames.id
 * @param array $data post data
 * @return CakeResponse
 */
	private function __editPublishMessage($frameId, $data) {
		var_dump($this->data);
		//exit();
	}

/**
 * 権限の更新処理実行
 *
 * @param string $type public or edit
 * @param int $frameId frames.id
 * @param array $data post
 * @return CakeResponse
 */
	private function __updateBlockParts($type, $frameId, $data) {
		if ($blockPart = $this->AnnouncementBlockPart->updateParts($type, $frameId, $data, $this->userId)) {
			//結果を返す : json
			$result = array(
				'status' => 'success',
				'message' => __('保存しました'),
				'data' => $blockPart
			);
			$this->set(compact('result'));
			$this->set('_serialize', 'result');
			return $this->render();
		}
		//更新失敗 500エラー
		return $this->__ajaxError(500, __("更新に失敗しました。"));
	}

/**
 * エラーをjsonで返す
 *
 * @param int $statusCode status code
 * @param string $errorMessage message
 * @return CakeResponse
 */
	private function __ajaxError($statusCode, $errorMessage) {
		$this->response->statusCode($statusCode);
		$result = array(
			'status' => 'error',
			'message' => $errorMessage,
		);
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
		return $this->render();
	}

/**
 * 追加
 *
 * @param string $type タイプ
 * @param int $frameId flames.id
 * @return CakeResponse
 */
	public function add($type, $frameId) {
	}

/**
 * 削除
 *
 * @param string $type type
 * @param int $frameId flames.id
 * @return CakeResponse
 */
	public function delete($type, $frameId) {
		//必ずpostで
		// blockの削除
		// 記事のみ削除 announcement_data.id
	}

/**
 * post用のformを取得する(javascript側でトークンを取得するために必要）
 *
 * @param string $type formのタイプ
 * @param int $frameId frames.id
 * @param int $blockId blocks.id 存在しない場合もある。
 * @return void
 */
	public function get_edit_form($type, $frameId, $blockId) {
		$this->layout = false;
		$this->__setFrame($frameId);
		$this->__setPartList();
		$this->__setCheckPart();
		//type別にフォームを返す
		if ($type == "editParts") {
			//タイプ別フォーム : 権限設定
			return $this->render("AnnouncementsBlockSetting/get_edit_form/edit_parts");
		} elseif ($type == "publishParts") {
			return $this->render("AnnouncementsBlockSetting/get_edit_form/publish_parts");
		} elseif ($type == "publishMessage") {
			//タイプ別フォーム：承認申請通知
			return $this->render("AnnouncementsBlockSetting/get_edit_form/publish_message");
		} elseif ($type == "updateMessage") {
			//タイプ別フォーム：更新通知設定
			return $this->render("AnnouncementsBlockSetting/get_edit_form/update_message");
		}
		//該当のフォームが無い
		return $this->__ajaxError(404, __('登録できません'));
	}

/**
 * frame 取得
 *
 * @param int $frameId flames.id
 * @return mixed
 */
	private function __setFrame($frameId) {
		//権限の確認。edit_blockの権限がなければ404エラー
		//_setFrame内で諸々権限の状態を格納する。
		return $this->_setFrame($frameId);
	}
}