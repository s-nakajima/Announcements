<?php
/**
 * AnnouncementPartsSettingFixture
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for AnnouncementPartsSettingFixture
 */
class AnnouncementPartsSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'part_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'read_content' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'edit_content' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'create_content' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'publish_content' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'mail_sendable' => array('type' => 'boolean', 'null' => true, 'default' => null),
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
			'part_id' => 1,
			'read_content' => 1,
			'edit_content' => 1,
			'create_content' => 1,
			'publish_content' => 1,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 2,
			'block_id' => 1,
			'part_id' => 1,
			'read_content' => 1,
			'edit_content' => 1,
			'create_content' => 1,
			'publish_content' => 0,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 3,
			'block_id' => 1,
			'part_id' => 1,
			'read_content' => 1,
			'edit_content' => 0,
			'create_content' => 1,
			'publish_content' => 0,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 4,
			'block_id' => 1,
			'part_id' => 4,
			'read_content' => 1,
			'edit_content' => 0,
			'create_content' => 1,
			'publish_content' => 0,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 5,
			'block_id' => 1,
			'part_id' => 5,
			'read_content' => 1,
			'edit_content' => 1,
			'create_content' => 1,
			'publish_content' => 0,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 6,
			'block_id' => 2,
			'part_id' => 1,
			'read_content' => 1,
			'edit_content' => 1,
			'create_content' => 1,
			'publish_content' => 0,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 7,
			'block_id' => 2,
			'part_id' => 3,
			'read_content' => 1,
			'edit_content' => 1,
			'create_content' => 1,
			'publish_content' => 0,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 8,
			'block_id' => 2,
			'part_id' => 4,
			'read_content' => 1,
			'edit_content' => 1,
			'create_content' => 1,
			'publish_content' => 0,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 9,
			'block_id' => 2,
			'part_id' => 4,
			'read_content' => 1,
			'edit_content' => 0,
			'create_content' => 1,
			'publish_content' => 0,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
		array(
			'id' => 10,
			'block_id' => 2,
			'part_id' => 5,
			'read_content' => 1,
			'edit_content' => 0,
			'create_content' => 0,
			'publish_content' => 0,
			'mail_sendable' => 0,
			'created' => '2014-08-23 09:16:52',
			'created_user_id' => 1,
			'modified' => '2014-08-23 09:16:52',
			'modified_user_id' => 1
		),
	);

}
