<?php
/**
 * AnnouncementBlocksPartFixture
 *
 */
class AnnouncementBlocksPartFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'announcement_block_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'part_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'can_create_content' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'can_publish_content' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'can_send_mail' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'announcement_blocks_parts_block_id' => array('column' => array('announcement_block_id', 'part_id'), 'unique' => 1)
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
			'announcement_block_id' => 10,
			'part_id' => 1,
			'can_create_content' => true,
			'can_publish_content' => true,
			'can_send_mail' => false,
			'created' => '2014-05-06 01:16:23',
			'modified' => '2014-05-06 01:18:31'
		),
		array(
			'id' => 11,
			'announcement_block_id' => 10,
			'part_id' => 2,
			'can_create_content' => true,
			'can_publish_content' => true,
			'can_send_mail' => false,
			'created' => '2014-05-06 01:16:23',
			'modified' => '2014-05-06 01:18:31'
		),
		array(
			'id' => 12,
			'announcement_block_id' => 10,
			'part_id' => 3,
			'can_create_content' => false,
			'can_publish_content' => false,
			'can_send_mail' => false,
			'created' => '2014-05-06 01:16:23',
			'modified' => '2014-05-06 01:18:31'
		),
		array(
			'id' => 13,
			'announcement_block_id' => 10,
			'part_id' => 4,
			'can_create_content' => false,
			'can_publish_content' => false,
			'can_send_mail' => false,
			'created' => '2014-05-06 01:16:23',
			'modified' => '2014-05-06 01:18:31'
		)
	);

}
