<?php
/**
 * PartsRoomsUserFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for PartsRoomsUserFixture
 */
class PartsRoomsUserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'part_id' => array('type' => 'integer', 'null' => false, 'default' => null),
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
			'id' => 1,
			'room_id' => 1,
			'user_id' => 1,
			'part_id' => 1,
			'created_user_id' => 1,
			'created' => '2014-08-25 00:59:49',
			'modified_user_id' => 1,
			'modified' => '2014-08-25 00:59:49'
		),
		array(
			'id' => 2,
			'room_id' => 1,
			'user_id' => 2,
			'part_id' => 2,
			'created_user_id' => 1,
			'created' => '2014-08-25 00:59:49',
			'modified_user_id' => 1,
			'modified' => '2014-08-25 00:59:49'
		),
	);

}
