<?php
/**
 * AnnouncementSettingFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for AnnouncementSettingFixture
 */
class AnnouncementSettingFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'announcement_settings';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'sendable_request' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'sendable_update' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
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
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 2,
			'block_id' => 2,
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 2,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 2
		),
		array(
			'id' => 3,
			'block_id' => 3,
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 3,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 3
		),
		array(
			'id' => 4,
			'block_id' => 4,
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 4,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 4
		),
		array(
			'id' => 5,
			'block_id' => 5,
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 5,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 5
		),
		array(
			'id' => 6,
			'block_id' => 6,
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 6,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 6
		),
		array(
			'id' => 7,
			'block_id' => 7,
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 7,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 7
		),
		array(
			'id' => 8,
			'block_id' => 8,
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 8,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 8
		),
		array(
			'id' => 9,
			'block_id' => 9,
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 9,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 9
		),
		array(
			'id' => 10,
			'block_id' => 10,
			'sendable_request' => 1,
			'sendable_update' => 1,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 10,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 10
		),
	);

}
