<?php
/**
 * PartFixture
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for PartFixture
 */
class PartFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'type' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
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
			'id' => '1',
			'type' => '2',
			'created_user_id' => null,
			'created' => '2014-05-29 04:26:55',
			'modified_user_id' => null,
			'modified' => '2014-05-29 04:26:55'
		),
		array(
			'id' => '2',
			'type' => '2',
			'created_user_id' => null,
			'created' => '2014-05-29 04:26:55',
			'modified_user_id' => null,
			'modified' => '2014-05-29 04:26:55'
		),
		array(
			'id' => '3',
			'type' => '2',
			'created_user_id' => null,
			'created' => '2014-05-29 04:26:55',
			'modified_user_id' => null,
			'modified' => '2014-05-29 04:26:55'
		),
		array(
			'id' => '4',
			'type' => '2',
			'created_user_id' => null,
			'created' => '2014-05-29 04:26:55',
			'modified_user_id' => null,
			'modified' => '2014-05-29 04:26:55'
		),
		array(
			'id' => '5',
			'type' => '2',
			'created_user_id' => null,
			'created' => '2014-05-29 04:26:55',
			'modified_user_id' => null,
			'modified' => '2014-05-29 04:26:55'
		),
	);

}
