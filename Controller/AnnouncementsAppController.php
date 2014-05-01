<?php

App::uses('AppController', 'Controller');

class AnnouncementsAppController extends AppController {

/**
 * レイアウト
 *
 * @var string
 */
	public $layout = 'NetCommons.default';	// TODO: test

/**
 * beforeFilter
 * @param   void
 * @return  void
 */
	public function beforeFilter() {
		// TODO: test 共通でやるべき。
		parent::beforeFilter();

		if ($this->request->is('ajax')) {
			$this->layout = 'ajax';
		}

		// TODO: コアでblock_id,frame_idがセットされる前提で作成
		$blockId = empty($this->request->params['pass'][0]) ? 0 : intval($this->request->params['pass'][0]);
		$this->set('block_id', $blockId);
		$this->set('frame_id', 1);
	}
}
