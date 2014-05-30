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
	public $uses = array('Block', 'Frames.Frame');

/**
 * Components used
 *
 * @var array
 */
	public $components = array('Announcements.AnnouncementsAuth');

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
		if (!$this->AnnouncementsAuth->canEditBlock($blockId)) {
			throw new ForbiddenException(__('Invalid auth'));
		}
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
		$blockId = $this->_findBlockIdByFrameId($frameId);
		if (!$blockId) {
			throw new NotFoundException(__('Invalid frame'));
		}

		$canEdit = $this->AnnouncementsAuth->canEditContent($blockId);
		if (($this->action == 'edit' && !$canEdit) ||
			!$this->AnnouncementsAuth->canReadContent($blockId)) {
			throw new ForbiddenException(__('Invalid auth'));
		}

		$this->request->params['pass'][1] = $blockId;

		$this->set('block_id', $blockId);
		$this->set('frame_id', $frameId);
		$this->set('can_edit', $canEdit);
	}

/**
 * _findBlockIdByFrameId
 * FrameModelへ移動するべき。
 * @param   integer $frameId
 * @return  mixed $blockId or false
 */
	protected function _findBlockIdByFrameId($frameId) {
		$frame = $this->Frame->find('first', array(
			'fields' => 'block_id',
			'recursive' => -1,
			'conditions' => array('id' => $frameId)
		));
		if (!isset($frame['Frame']['block_id'])) {
			return false;
		}
		return $frame['Frame']['block_id'];
	}

}
