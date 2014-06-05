<?php
/**
 * AnnouncementFixture
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for AnnouncementFixture
 */
class AnnouncementFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'announcements_block_id' => array('column' => 'block_id', 'unique' => 1)
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
			'created' => '2014-06-05 13:16:21',
			'create_user_id' => 1,
			'modified' => '2014-06-05 13:16:21',
			'modified_user_id' => 1
		),
	);

}
