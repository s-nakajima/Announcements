<?php
/**
 * AnnouncementBlockSettingFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for AnnouncementBlockSettingFixture
 */
class AnnouncementBlockSettingFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'announcement_block_setting';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'is_send_request' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'is_send_update' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
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
			'is_send_request' => 1,
			'is_send_update' => 1,
			'created' => '2014-07-16 06:29:10',
			'create_user_id' => 1,
			'modified' => '2014-07-16 06:29:10',
			'modified_user_id' => 1
		),
	);

}
