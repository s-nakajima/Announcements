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
 * @param integer $frameId
 * @param integer $blockId
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
 * @param integer $frameId
 * @param integer $blockId
 * @return void
 * @access public
 * @throws InternalErrorException saveに失敗したとき。
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
 * @param integer $blockId
 * @return void
 * @access public
 * @throws InternalErrorException saveに失敗したとき。
 */
	public function block_setting($blockId = 0) {
		// TODO: Block.titleのお知らせ名称を変更できない。
		$announcementBlock = $this->AnnouncementBlock->findByBlockIdOrDefault($blockId);

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data = $this->AnnouncementBlock->mergeRequestId($this->request->data, $announcementBlock);
			if ($this->AnnouncementBlock->saveAll($this->request->data)) {
				// return $this->redirect(array('action' => 'index', $blockId));
				$this->autoRender = false;
				// $this->Session->setFlash(__('Has been successfully registered.'));
				return true;
			} elseif (!$this->AnnouncementBlock->validationErrors) {
				throw new InternalErrorException(__('Failed to update the database, (%s).', 'announcement_blocks'));
			}
		}

		if (!$this->request->data && $blockId > 0) {
			$this->request->data = $announcementBlock;
		}

		$this->__afterAction();
	}

/**
 * __afterAction
 * @param   void
 * @return  void
 */
	private function __afterAction() {
		if (!$this->request->data) {
			return $this->render('content_not_found');
		}
		$this->render();	// Testで取得出来るようにするため
	}
}
