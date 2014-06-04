<?php
/**
 * Announcements Controller
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AnnouncementsAppController', 'Announcements.Controller');

class AnnouncementsController extends AnnouncementsAppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array('Announcements.Announcement', 'Announcements.AnnouncementBlock', 'Announcements.AnnouncementRevision');

/**
 * 使用するヘルパー
 *
 * @var array
 */
	public $helpers = array('RichTextEditor.RichTextEditor');

/**
 * 使用するコンポーネント
 *
 * @var array
 */
	public $components = array(
		'Security'
	);

/**
 * Index
 *
 * @param integer $frameId frameID
 * @param integer $blockId blockID
 * @return void
 * @access public
 */
	public function index($frameId = 0, $blockId = 0) {
		$this->request->data = $this->Announcement->findByBlockId($blockId);
		$this->__afterAction();
	}

/**
 * お知らせ編集画面
 *
 * @param integer $frameId frameID
 * @param integer $blockId blockID
 * @access public
 * @throws InternalErrorException saveに失敗したとき。
 * @return void
 */
	public function edit($frameId = 0, $blockId = 0) {
		$announcement = $this->Announcement->findByBlockId($blockId);
		if (!$announcement) {
			$announcement = $this->Announcement->create();
			$announcement[$this->Announcement->alias]['block_id'] = $blockId;
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data = $this->Announcement->mergeRequestId($this->request->data, $announcement);
			if ($this->Announcement->save($this->request->data)) {
				return $this->redirect(array('action' => 'index', $blockId));
			} elseif (!$this->Announcement->validationErrors && !$this->AnnouncementRevision->validationErrors) {
				throw new InternalErrorException(__('Failed to update the database, (%s).', 'announcements'));
			}
		}

		if (!$this->request->data && $blockId > 0) {
			$this->request->data = $announcement;
		}
		$this->__afterAction();
	}

/**
 * お知らせBlock設定画面
 *
 * @param integer $blockId blockID
 * @access public
 * @throws InternalErrorException saveに失敗したとき。
 * @return void
 */
	public function block_setting($blockId = 0) {
		$announcementBlock = $this->AnnouncementBlock->findByBlockIdOrDefault($blockId);
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data = $this->AnnouncementBlock->mergeRequestId($this->request->data, $announcementBlock);

			// バリデートエラー
			$blocksLanguage['BlocksLanguage'] = array(
				'id' => $this->block['Language'][0]['BlocksLanguage']['id'],
				'name' => $this->request->data['BlocksLanguage']['name'],
			);
			$this->BlocksLanguage->set($blocksLanguage);
			$this->AnnouncementBlock->set($this->request->data);
			if (!$this->BlocksLanguage->validates(array('fieldList' => array('name'))) ||
				!$this->AnnouncementBlock->validates()) {
				$this->__afterAction();
				return;
			}

			// お知らせタイトル
			if (!$this->BlocksLanguage->save($blocksLanguage)) {
				throw new InternalErrorException(__('Failed to update the database, (%s).', 'blocks_languages'));
			}

			// お知らせブロック設定
			if (!$this->AnnouncementBlock->saveAll($this->request->data)) {
				throw new InternalErrorException(__('Failed to update the database, (%s).', 'announcement_blocks'));
			}
			$this->autoRender = false;
			// $this->Session->setFlash(__('Has been successfully registered.'));
			return true;
		}

		if (!$this->request->data && $blockId > 0) {
			$this->request->data = $announcementBlock;
			$this->request->data['BlocksLanguage'] = $this->block['Language'][0]['BlocksLanguage'];
		}

		$this->__afterAction();
	}

/**
 * __afterAction
 *
 * @return void
 */
	private function __afterAction() {
		if (!$this->request->data) {
			return $this->render('content_not_found');
		}
		$this->render();	// Testで取得出来るようにするため
	}
}
