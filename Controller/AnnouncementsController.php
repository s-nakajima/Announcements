<?php
/**
 * Announcements Controller
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
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
	public $uses = array(
		'Announcements.Announcement',
		'Announcements.AnnouncementBlock',
		'Announcements.AnnouncementDatum'
	);

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
	}


}
