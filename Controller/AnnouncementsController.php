<?php

App::uses('AnnouncementsAppController', 'Announcements.Controller');

class AnnouncementsController extends AnnouncementsAppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array('Announcements.Announcement', 'Announcements.AnnouncementBlock');

/**
 * 使用するヘルパー
 *
 * @var array
 */
	public $helpers = array('TinyMCE.TinyMCE');

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
 * @param integer $blockId
 * @return void
 * @access public
 */
	public function index($blockId = 0) {
		$this->request->data = $this->Announcement->findByBlockId($blockId);
		$this->__afterAction();
	}

/**
 * Edit
 *
 * @param integer $blockId
 * @return void
 * @access public
 */
	public function edit($blockId = 0) {
		// TODO: 投稿権限のチェックが必要。
		if ($this->request->is(array('put', 'post')) && !empty($this->request->data)) {
			if ($this->Announcement->save($this->request->data)) {
				return $this->redirect(array('action' => 'index', $blockId));
			} else {
				throw new InternalErrorException(__('Failed to update the database, (%s).', 'announcements'));
			}
		}

		if (!$this->request->data && $blockId > 0) {
			$this->request->data = $this->Announcement->findByBlockId($blockId);
			if (!$this->request->data) {
				$this->request->data = $this->Announcement->create();
			}
		}
		$this->__afterAction();
	}

/**
 * Block
 *
 * @param integer $blockId
 * @return void
 * @access public
 */
	public function block($blockId = 0) {
		// TODO: 編集権限のチェックが必要。
		// TODO: Block.titleのカラムがないため、お知らせ名称を変更できない。
		// TODO: Block.titleのデフォルト値の設定箇所も作成していない。
		if ($this->request->is(array('put', 'post')) && !empty($this->request->data)) {
			if ($this->Block->saveAll($this->request->data)) {
				// return $this->redirect(array('action' => 'index', $blockId));
				$this->autoRender = false;
				// $this->Session->setFlash(__('Has been successfully registered.'));
				return true;
			} else {
				throw new InternalErrorException(__('Failed to update the database, (%s).', 'announcement_blocks'));
			}
		}

		if (!$this->request->data && $blockId > 0) {
			$this->request->data = $this->AnnouncementBlock->findByBlockIdOrDefault($blockId);
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
