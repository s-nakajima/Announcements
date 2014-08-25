<?php
/**
 * AnnouncementFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for AnnouncementFixture
 */
class AnnouncementFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'announcements_block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'is_auto_translation' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'announcements_block_id' => 1,
			'status' => 1,
			'language_id' => 1,
			'is_auto_translation' => 1,
			'translation_engine' => null,
			'content' => 'Content Publish',
			'created' => '2014-08-25 15:11:48',
			'created_user' => 1,
			'modified' => '2014-08-25 15:11:48',
			'modified_user' => 1
		),
		array(
			'id' => 2,
			'announcements_block_id' => 1,
			'status' => 3,
			'language_id' => 1,
			'is_auto_translation' => 1,
			'translation_engine' => null,
			'content' => 'Content Draft',
			'created' => '2014-08-25 15:11:48',
			'created_user' => 1,
			'modified' => '2014-08-25 15:11:48',
			'modified_user' => 1
		),

	);

}
