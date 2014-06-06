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
		'Announcements.AnnouncementDatum',
		'Block',
		'BlocksLanguage',
		'Frames.Frame',
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
		$this->set('frameId' , $frameId);
		$this->set('blockId' , $blockId);
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
		if(count($_POST))
		{
			return $this->_post();

		}
		$this->set('frameId' , $frameId);
		$this->set('blockId' , $blockId);
	}

	public function post($frameId=0)
	{
		$this->layout = false;
		$this->set('frameId' , $frameId);
		//echo encodeURIComponent($_POST["data"]["AnnouncementDatum"]["content"]);
		var_dump($_POST);
		return $this->render();
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
		$this->set('blockId' , $blockId);
	}

	//フォームの取得
	public function get_edit_form($frameId = null , $blockId = 0) {
		//$frameId check
		//if notice 404 error
		$this->layout = false;
		$this->set('frameId' , $frameId);
		$this->set('blockId' , $blockId);
	}


}
