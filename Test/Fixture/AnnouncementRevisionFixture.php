<?php
/**
 * AnnouncementRevisionFixture
 *
 */
class AnnouncementRevisionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'announcement_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
		'status_id' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'announcement_id' => array('column' => 'announcement_id', 'unique' => 1)
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
			'announcement_id' => '10',
			'status_id' => '1',
			'content' => 'NetCommonsはCMS（Contents Management System)とLMS（Learning Management System)とグループウェアを統合したコミュニティウェアです。',
		),
	);

}
