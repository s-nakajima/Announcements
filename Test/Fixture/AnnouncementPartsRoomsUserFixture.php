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
class AnnouncementPartsRoomsUserFixture extends CakeTestFixture {

/**
 * table
 *
 * @var string
 */
	public $table = 'parts_rooms_users';

/**
 * db config
 *
 * @var string
 */
	public $useDbConfig = 'test';

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
			'created' => '2014-06-02 16:18:02',
			'modified_user_id' => 1,
			'modified' => '2014-06-02 16:18:02'
		),
		array(
			'id' => 2,
			'room_id' => 1,
			'user_id' => 2,
			'part_id' => 2,
			'created_user_id' => 1,
			'created' => '2014-06-02 16:18:02',
			'modified_user_id' => 1,
			'modified' => '2014-06-02 16:18:02'
		),
		array(
			'id' => 3,
			'room_id' => 9,
			'user_id' => 1,
			'part_id' => 2,
			'created_user_id' => 1,
			'created' => '2014-06-02 16:18:02',
			'modified_user_id' => 1,
			'modified' => '2014-06-02 16:18:02'
		),
		array(
			'id' => 4,
			'room_id' => 2,
			'user_id' => 9,
			'part_id' => 2,
			'created_user_id' => 1,
			'created' => '2014-06-02 16:18:02',
			'modified_user_id' => 1,
			'modified' => '2014-06-02 16:18:02'
		)
	);

}
