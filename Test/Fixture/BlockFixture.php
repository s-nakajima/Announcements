<?php
/**
 * BlockFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for BlockFixture
 */
class BlockFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('connection' => 'master');

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'id' => '1',
			'room_id' => '1',
			'created_user_id' => null,
			'created' => '2014-08-24 23:35:05',
			'modified_user_id' => null,
			'modified' => '2014-08-24 23:35:05'
		),
		array(
			'id' => '2',
			'room_id' => '1',
			'created_user_id' => null,
			'created' => '2014-08-24 23:35:05',
			'modified_user_id' => null,
			'modified' => '2014-08-24 23:35:05'
		),
		array(
			'id' => '3',
			'room_id' => '1',
			'created_user_id' => null,
			'created' => '2014-08-24 23:35:05',
			'modified_user_id' => null,
			'modified' => '2014-08-24 23:35:05'
		),
		array(
			'id' => '4',
			'room_id' => '1',
			'created_user_id' => null,
			'created' => '2014-08-24 23:35:05',
			'modified_user_id' => null,
			'modified' => '2014-08-24 23:35:05'
		),
		array(
			'id' => '5',
			'room_id' => '1',
			'created_user_id' => null,
			'created' => '2014-08-24 23:35:05',
			'modified_user_id' => null,
			'modified' => '2014-08-24 23:35:05'
		),
	);

}
