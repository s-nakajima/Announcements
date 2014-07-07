<?php
/**
 * AnnouncementsBlockSetting Controller
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
App::uses(
	'AnnouncementsAppController',
	'Announcements.Controller'
);

class AnnouncementsBlockSettingController extends AnnouncementsAppController {

/**
 * index
 *
 * @return void
 */
	public function index($frameId) {
		$this->layout = false;
		$this->set('frameId', $frameId);
		$this->set('partList' , $this->__getPartList());
	}

	function __getPartList() {
		//2の場合は可変
		$data = array(
			0=>array(
				'roomParts'=>array(
					'id'=>1,
					'part_id'=>1,
					'can_read_page'=>1,
					'can_edit_page'=>1,
					'can_create_page'=>1,
					'can_publish_page'=>1,
					'can_read_block'=>1,
					'can_edit_block'=>1,
					'can_create_block'=>1,
					'can_publish_block'=>1,
					'can_read_content'=>1,
					'can_edit_content'=>1,
					'can_create_content'=>1,
					'can_publish_content'=>1,
					'created_user_id'=>1,
					'created'=>'2014-07-03 12:30:59',
					'modified_user_id'=>NULL,
					'modified'=>NULL,
				),
				'languagesParts'=>array(
					'id'=>"",
					'part_id'=>1,
					'language_id'=>"2",
					'name'=>"ルーム管理者",
					'created_user_id'=>1,
					'created'=>'2014-07-03 12:30:59',
					'modified_user_id'=>NULL,
					'modified'=>NULL,
				)
			),
			1=>array(
				'roomParts'=>array(
					'id'=>2,
					'part_id'=>2,
					'can_read_page'=>1,
					'can_edit_page'=>1,
					'can_create_page'=>1,
					'can_publish_page'=>1,
					'can_read_block'=>1,
					'can_edit_block'=>1,
					'can_create_block'=>1,
					'can_publish_block'=>1,
					'can_read_content'=>1,
					'can_edit_content'=>1,
					'can_create_content'=>1,
					'can_publish_content'=>2,
					'created_user_id'=>1,
					'created'=>'2014-07-03 12:30:59',
					'modified_user_id'=>NULL,
					'modified'=>NULL,
				),
				'languagesParts'=>array(
					'id'=>2,
					'part_id'=>2,
					'language_id'=>"2",
					'name'=>"編集長",
					'created_user_id'=>1,
					'created'=>'2014-07-03 12:30:59',
					'modified_user_id'=>NULL,
					'modified'=>NULL,
				)
			),
			2=>array(
				'roomParts'=>array(
					'id'=>3,
					'part_id'=>3,
					'can_read_page'=>1,
					'can_edit_page'=>1,
					'can_create_page'=>1,
					'can_publish_page'=>1,
					'can_read_block'=>1,
					'can_edit_block'=>1,
					'can_create_block'=>1,
					'can_publish_block'=>1,
					'can_read_content'=>1,
					'can_edit_content'=>0,
					'can_create_content'=>0,
					'can_publish_content'=>2,
					'created_user_id'=>1,
					'created'=>'2014-07-03 12:30:59',
					'modified_user_id'=>NULL,
					'modified'=>NULL,
				),
				'languagesParts'=>array(
					'id'=>3,
					'part_id'=>3,
					'language_id'=>"2",
					'name'=>"編集者",
					'created_user_id'=>1,
					'created'=>'2014-07-03 12:30:59',
					'modified_user_id'=>NULL,
					'modified'=>NULL,
				)
			),
			3=>array(
				'roomParts'=>array(
					'id'=>4,
					'part_id'=>4,
					'can_read_page'=>1,
					'can_edit_page'=>1,
					'can_create_page'=>1,
					'can_publish_page'=>1,
					'can_read_block'=>1,
					'can_edit_block'=>1,
					'can_create_block'=>1,
					'can_publish_block'=>1,
					'can_read_content'=>1,
					'can_edit_content'=>0,
					'can_create_content'=>0,
					'can_publish_content'=>0,
					'created_user_id'=>1,
					'created'=>'2014-07-03 12:30:59',
					'modified_user_id'=>NULL,
					'modified'=>NULL,
				),
				'languagesParts'=>array(
					'id'=>4,
					'part_id'=>4,
					'language_id'=>"2",
					'name'=>"一般",
					'created_user_id'=>1,
					'created'=>'2014-07-03 12:30:59',
					'modified_user_id'=>NULL,
					'modified'=>NULL,
				)
			)
		);
		return $data;
	}


}