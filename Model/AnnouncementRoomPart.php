<?php
/**
 * AnnouncementRoomPart Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

class AnnouncementRoomPart extends AppModel {

/**
 * テーブルの指定
 * @var bool
 */
	public $useTable = 'room_parts';

/**
 * name
 *
 * @var string
 */
	public $name = "AnnouncementRoomPart";

/**
 * language id デェフォルト値
 *
 * @var int
 */
	public $languageId = 2;

/**
 * __construct
 *
 * @param bool $id id
 * @param null $table db table
 * @param null $ds connection
 * @return void
 * @SuppressWarnings(PHPMD)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}

/**
 * パート一覧
 *
 * @param int $langId languages.id
 * @return array
 */
	public function getList($langId = 2) {
		return $this->find('all', array(
			'joins' => array(
				array(
					'type' => 'LEFT',
					'table' => 'languages_parts',
					'alias' => 'LanguagesPart',
					'conditions' => array(
						'LanguagesPart.part_id=AnnouncementRoomPart.part_id',
						'LanguagesPart.language_id=' . $langId //言語id
						)
					)
				),
				'fields' => array(
					'AnnouncementRoomPart.*',
					'LanguagesPart.name'
				),
				'order' => array('AnnouncementRoomPart.hierarchy DESC')
			)
		);
	}
}
