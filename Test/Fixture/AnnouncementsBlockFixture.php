<?php
/**
 * AnnouncementsBlockFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for AnnouncementsBlockFixture
 */
class AnnouncementsBlockFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
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
		array (
			'id' => 1,
			'block_id' => 1,
			'created_user_id' => 1
		),
		array (
			'id' => 2,
			'block_id' => 2,
			'created_user_id' => 1
		),
		array (
			'id' => 3,
			'block_id' => 3,
			'created_user_id' => 1
		),
		array (
			'id' => 4,
			'block_id' => 4,
			'created_user_id' => 1
		),
		array (
			'id' => 5,
			'block_id' => 5,
			'created_user_id' => 1
		)
	);

}
