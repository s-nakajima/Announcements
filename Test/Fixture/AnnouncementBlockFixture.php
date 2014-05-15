<?php
/**
 * AnnouncementBlockFixture
 *
 */
class AnnouncementBlockFixture extends CakeTestFixture {

	//public $table = 'announcement_blocks';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'unique'),
		'send_mail' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'mail_subject' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mail_body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'announcement_blocks_block_id' => array('column' => 'block_id', 'unique' => 1)
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
			'id' => 10,
			'block_id' => 1,
			'send_mail' => true,
			'mail_subject' => 'Mail Subject',
			'mail_body' => 'Mail Body',
			'created' => '2014-05-06 01:16:23',
			'modified' => '2014-05-06 01:18:31'
		)
	);

}
