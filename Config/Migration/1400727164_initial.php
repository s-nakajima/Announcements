schema.php<?php
class Initial extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'announcement_blocks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'send_mail' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
					'mail_subject' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'mail_body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'announcement_blocks_block_id' => array('column' => 'block_id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcement_blocks_parts' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'announcement_block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'part_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'can_edit_content' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'can_publish_content' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'can_send_mail' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'announcement_blocks_parts_announcement_block_id' => array('column' => array('announcement_block_id', 'part_id'), 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcement_revisions' => array(
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
						'announcement_revisions_announcement_id' => array('column' => 'announcement_id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcements' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'is_published' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'announcements_block_id' => array('column' => 'block_id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'announcement_blocks', 'announcement_blocks_parts', 'announcement_revisions', 'announcements'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function after($direction) {
		return true;
	}
}
