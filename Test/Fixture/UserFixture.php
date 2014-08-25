<?php
/**
 * UserFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for UserFixture
 */
class UserFixture extends CakeTestFixture {

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
		'username' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'role_id' => array('type' => 'integer', 'null' => false, 'default' => null),
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
			'username' => 'admin',
			'password' => 'f14c95a14885415b30c8f3cd7603da0cfce5acdebaac646ee7c9b6928243e1f7871dde7eeb273de6314e431684723623490b7ce144697e00473872f01ad8b72c',
			'role_id' => '1',
			'created_user_id' => null,
			'created' => '2014-08-24 23:42:08',
			'modified_user_id' => null,
			'modified' => '2014-08-24 23:42:08'
		),
		array(
			'id' => 2,
			'username' => 'admin2',
			'password' => 'f14c95a14885415b30c8f3cd7603da0cfce5acdebaac646ee7c9b6928243e1f7871dde7eeb273de6314e431684723623490b7ce144697e00473872f01ad8b72c',
			'role_id' => '1',
			'created_user_id' => null,
			'created' => '2014-08-24 23:42:08',
			'modified_user_id' => null,
			'modified' => '2014-08-24 23:42:08'
		),
	);

}
