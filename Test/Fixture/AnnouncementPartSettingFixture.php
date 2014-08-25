<?php
/**
 * AnnouncementPartSettingFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for AnnouncementPartSettingFixture
 */
class AnnouncementPartSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'part_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'readable_content' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'createable_content' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'editable_content' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'publishable_content' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'mail_sendable' => array('type' => 'boolean', 'null' => true, 'default' => null),
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
			'block_id' => 1,
			'part_id' => 1,
			'readable_content' => 1,
			'createable_content' => 1,
			'editable_content' => 1,
			'publishable_content' => 1,
			'mail_sendable' => 1,
			'created' => '2014-08-25 15:15:27',
			'created_user' => 1,
			'modified' => '2014-08-25 15:15:27',
			'modified_user' => 1
		),
	);

}
