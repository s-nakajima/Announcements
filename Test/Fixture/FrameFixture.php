<?php
/**
 * FrameFixture
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for FrameFixture
 */
class FrameFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'box_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
		'plugin_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'block_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'from' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'to' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'box_id' => '1',
			'parent_id' => '0',
			'lft' => null,
			'rght' => null,
			'plugin_id' => '1',
			'block_id' => '1',
			'weight' => '1',
			'is_published' => 1,
			'from' => null,
			'to' => null,
			'created_user_id' => null,
			'created' => '2014-05-28 10:21:40',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:40'
		),
		array(
			'id' => '2',
			'box_id' => '2',
			'parent_id' => '0',
			'lft' => null,
			'rght' => null,
			'plugin_id' => '1',
			'block_id' => '2',
			'weight' => '1',
			'is_published' => 1,
			'from' => null,
			'to' => null,
			'created_user_id' => null,
			'created' => '2014-05-28 10:21:40',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:40'
		),
		array(
			'id' => '3',
			'box_id' => '3',
			'parent_id' => '0',
			'lft' => null,
			'rght' => null,
			'plugin_id' => '1',
			'block_id' => '3',
			'weight' => '1',
			'is_published' => 1,
			'from' => null,
			'to' => null,
			'created_user_id' => null,
			'created' => '2014-05-28 10:21:40',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:40'
		),
		array(
			'id' => '4',
			'box_id' => '4',
			'parent_id' => '0',
			'lft' => null,
			'rght' => null,
			'plugin_id' => '1',
			'block_id' => '4',
			'weight' => '1',
			'is_published' => 1,
			'from' => null,
			'to' => null,
			'created_user_id' => null,
			'created' => '2014-05-28 10:21:40',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:40'
		),
		array(
			'id' => '5',
			'box_id' => '5',
			'parent_id' => '0',
			'lft' => null,
			'rght' => null,
			'plugin_id' => '1',
			'block_id' => '5',
			'weight' => '1',
			'is_published' => 1,
			'from' => null,
			'to' => null,
			'created_user_id' => null,
			'created' => '2014-05-28 10:21:40',
			'modified_user_id' => null,
			'modified' => '2014-05-28 10:21:40'
		),
	);

}
