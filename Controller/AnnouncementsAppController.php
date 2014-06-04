<?php
/**
 * AnnouncementsAppController
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AppController', 'Controller');

class AnnouncementsAppController extends AppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array('Block', 'BlocksLanguage', 'Frames.Frame');

/**
 * Components used
 *
 * @var array
 */
	public $components = array('Announcements.AnnouncementsAuth');

/**
 * Block data
 *
 * @var array
 */
	public $block = array();

/**
 * beforeFilter
 * @param   void
 * @return  void
 * @throws NotFoundException block,frameが存在しない
 */
	public function beforeFilter() {
		parent::beforeFilter();

		if ($this->request->is('ajax')) {
			$this->layout = 'ajax';
		}

		if ($this->action == 'block_setting') {
			$this->_beforeFilterBlock();
			return;
		}

		$this->_beforeFilterFrame();
	}

/**
 * _beforeFilterBlock
 * @param   void
 * @return  void
 * @throws ForbiddenException 権限チェックエラー
 */
	protected function _beforeFilterBlock() {
		$blockId = empty($this->request->params['pass'][0]) ? 0 : intval($this->request->params['pass'][0]);

		$this->Block->hasAndBelongsToMany['Language']['conditions'] = array('Language.code' => 'jpn');	// テスト 固定値
		$block = $this->Block->findById($blockId);
		if (!$block) {
			throw new ForbiddenException(__('Invalid auth'));
		}
		if (!$this->AnnouncementsAuth->canEditBlock($blockId)) {
			throw new ForbiddenException(__('Invalid auth'));
		}
		$this->block = $block;
		$this->set('block_id', $blockId);
	}

/**
 * _beforeFilterFrame
 * @param   void
 * @return  void
 * @throws NotFoundException frameが存在しない
 * @throws ForbiddenException 権限チェックエラー
 */
	protected function _beforeFilterFrame() {
		$frameId = empty($this->request->params['pass'][0]) ? 0 : intval($this->request->params['pass'][0]);
		$blockId = $this->Frame->findBlockIdByFrameId($frameId);
		if ($blockId === false) {
			throw new NotFoundException(__('Invalid frame'));
		}
		if (empty($blockId)) {
			//取得できなければInsert
			$blockId = $this->_addBlock($frameId);
		}

		$canEdit = $this->AnnouncementsAuth->canEditContent($blockId);
		if (($this->action == 'edit' && !$canEdit) ||
			!$this->AnnouncementsAuth->canReadContent($blockId)) {
			throw new ForbiddenException(__('Invalid auth'));
		}

		$this->request->params['pass'][1] = $blockId;

		$this->set('blockId', $blockId);
		$this->set('frameId', $frameId);
		$this->set('canEdit', $canEdit);
	}

/**
 * _addBlock
 * @param   void
 * @return  $blockId
 * @throws InternalErrorException 追加エラー
 */
	protected function _addBlock($frameId) {
		$blockId = $this->Block->addBlock($frameId);
		if (!$blockId) {
			throw new InternalErrorException(__('Failed to register the database, (%s).', 'blocks'));
		}
		$this->Frame->id = $frameId;
		if (!$this->Frame->saveField('block_id', $blockId)) {
			throw new InternalErrorException(__('Failed to update the database, (%s).', 'frames'));
		}
		return $blockId;
	}

}
