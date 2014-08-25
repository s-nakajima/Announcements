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
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
		'part_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'readable_content' => array('type' => 'boolean', 'null' => true),
		'createable_content' => array('type' => 'boolean', 'null' => true),
		'editable_content' => array('type' => 'boolean', 'null' => false),
		'publishable_content' => array('type' => 'boolean', 'null' => false),
		'mail_sendable' => array('type' => 'boolean', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
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
			'readable_content' => true,
			'editable_content' => true,
			'createable_content' => true,
			'publishable_content' => true,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		),
		array(
			'id' => 2,
			'block_id' => 1,
			'part_id' => 2,
			'readable_content' => true,
			'editable_content' => false,
			'createable_content' => true,
			'publishable_content' => false,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		),
		array(
			'id' => 3,
			'block_id' => 1,
			'part_id' => 3,
			'readable_content' => true,
			'editable_content' => false,
			'createable_content' => true,
			'publishable_content' => false,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		),
		array(
			'id' => 4,
			'block_id' => 1,
			'part_id' => 4,
			'readable_content' => true,
			'editable_content' => false,
			'createable_content' => true,
			'publishable_content' => false,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		),
		array(
			'id' => 5,
			'block_id' => 1,
			'part_id' => 5,
			'readable_content' => true,
			'editable_content' => false,
			'createable_content' => false,
			'publishable_content' => false,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		),
		array(
			'id' => 6,
			'block_id' => 2,
			'part_id' => 1,
			'readable_content' => true,
			'editable_content' => true,
			'createable_content' => true,
			'publishable_content' => true,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		),
		array(
			'id' => 7,
			'block_id' => 2,
			'part_id' => 2,
			'readable_content' => true,
			'editable_content' => false,
			'createable_content' => true,
			'publishable_content' => false,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		),
		array(
			'id' => 8,
			'block_id' => 2,
			'part_id' => 3,
			'readable_content' => true,
			'editable_content' => false,
			'createable_content' => true,
			'publishable_content' => false,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		),
		array(
			'id' => 9,
			'block_id' => 2,
			'part_id' => 4,
			'readable_content' => true,
			'editable_content' => false,
			'createable_content' => true,
			'publishable_content' => false,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		),
		array(
			'id' => 10,
			'block_id' => 2,
			'part_id' => 5,
			'readable_content' => true,
			'editable_content' => false,
			'createable_content' => false,
			'publishable_content' => false,
			'mail_sendable' => false,
			'created' => '2014-08-23 09:16:52',
			'created_user' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user' => 1
		)
	);

}
