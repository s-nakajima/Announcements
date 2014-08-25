<?php
/**
 * AnnouncementsBlockSetting Controller
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AppController', 'Controller');
App::uses('AnnouncementsAppController', 'Announcements.Controller');

class AnnouncementsBlockSettingController extends AnnouncementsAppController {

/**
 * 準備
 *
 * @return void
 */
	public function beforeFilter() {
		//親処理
		parent::beforeFilter();
		//セッティングモード
		$this->set('isSetting', Configure::read('Pages.isSetting'));
		$this->_setLoginUserId();
		$this->set('isRoomAdmin', false);
	}

/**
 * パートの取得
 *
 * @return array
 */
	private function __setPartList() {
		//room_partの一覧を取得。setし返す。
		$rtn = $this->NetCommonsRoomPart->getList($this->langId);
		$this->set('partList', $this->NetCommonsRoomPart->getList($this->langId));
		return $rtn;
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
		$this->viewClass = 'Json';
		//postのみ許可
		if (! $this->request->isPost()) {
			return $this->__ajaxError(405, __("POSTのみ操作可能です。"));
		}
		if (! $this->_setFrame($frameId)) {
			//frameIdがおかしい
			return $this->__ajaxError(404, __('該当の情報が存在しません。'));
		}
		if (! $this->isBlockEdit) {
			return $this->__ajaxError(403, __("権限がありません。"));
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
		if (! $this->request->isPost()) {
			return $this->__ajaxError(404, __('存在しません'));
		}
		if (! $this->_setFrame($frameId)) {
			//frameIdがおかしい
			return $this->__ajaxError(404, __('該当の情報が存在しません。'));
		}
		if (! $this->isBlockEdit) {
			return $this->__ajaxError(403, __("権限がありません。"));
		}

		//データをmodelへ
		$rtn = $this->AnnouncementBlockMessage->dataSave($frameId, $this->data, $this->userId);
		if ($rtn) {
			$result = array(
				'status' => 'success',
				'message' => __('保存しました'),
			);
			$this->set(compact('result'));
			$this->set('_serialize', 'result');
			return $this->render();
		}
		if ($this->AnnouncementBlockMessage->validationErrors) {
			//バリデーションエラー
			return $this->__ajaxError(409, __('保存に失敗しました。'));
		}
		//例外エラー
		return $this->__ajaxError(500, __('保存に失敗しました。時間をおいて再度実行してください。'));
	}
/**
 * 公開申請通知設定の更新処理
 *
 * @param int $frameId flames.id
 * @param array $data post data
 * @return CakeResponse
 */
	private function __editPublishMessage($frameId, $data) {
		$result = array(
			'status' => 'success',
			'message' => __('保存しました'),
		);
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
		return $this->render();
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
		if ($blockPart = $this->AnnouncementBlockPart->updatePartsAbility($type, $frameId, $data, $this->userId)) {
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
 * post用のformを取得する(javascript側でトークンを取得するために必要）
 *
 * @param string $form formのタイプ
 * @param int $frameId frames.id
 * @param int $blockId blocks.id 存在しない場合もある。
 * @return void
 */
	public function form($form, $frameId, $blockId) {
		$this->layout = false;
		$this->_setFrame($frameId);
		$this->__setPartList();
		//type別にフォームを返す
		if ($form === "editParts") {
			//タイプ別フォーム : 権限設定
			return $this->render("AnnouncementsBlockSetting/get_edit_form/edit_parts");
		} elseif ($form === "publishParts") {
			return $this->render("AnnouncementsBlockSetting/get_edit_form/publish_parts");
		} elseif ($form === "publishMessage") {
			//タイプ別フォーム：承認申請通知
			return $this->render("AnnouncementsBlockSetting/get_edit_form/publish_message");
		} elseif ($form === "updateMessage") {
			//タイプ別フォーム：更新通知設定
			return $this->render("AnnouncementsBlockSetting/get_edit_form/update_message");
		}
		//該当のフォームが無い
		return $this->__ajaxError(404, __('登録できません'));
	}
}