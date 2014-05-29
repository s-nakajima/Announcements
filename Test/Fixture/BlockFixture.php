<?php
/**
 * BlockFixture
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for BlockFixture
 */
class BlockFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'room_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'created' => '2014-05-28 10:21:40',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:40'
		),
		array(
			'id' => '2',
			'room_id' => '1',
			'created_user_id' => null,
			'created' => '2014-05-28 10:21:40',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:40'
		),
		array(
			'id' => '3',
			'room_id' => '1',
			'created_user_id' => null,
			'created' => '2014-05-28 10:21:40',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:40'
		),
		array(
			'id' => '4',
			'room_id' => '1',
			'created_user_id' => null,
			'created' => '2014-05-28 10:21:40',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:40'
		),
		array(
			'id' => '5',
			'room_id' => '1',
			'created_user_id' => null,
			'created' => '2014-05-28 10:21:41',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:41'
		),
	);

}
