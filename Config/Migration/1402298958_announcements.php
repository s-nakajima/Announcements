<?php
/**
 * Announcements Migration
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class Announcements extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	//public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'announcements' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'announcements_block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
					'is_auto_translation' => array('type' => 'boolean', 'null' => true),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcements_blocks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcement_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'sendable_request' => array('type' => 'boolean', 'null' => true),
					'sendable_update' => array('type' => 'boolean', 'null' => true),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcement_part_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'part_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'readable_content' => array('type' => 'boolean', 'null' => true),
					'createable_content' => array('type' => 'boolean', 'null' => true),
					'editable_content' => array('type' => 'boolean', 'null' => false),
					'publishable_content' => array('type' => 'boolean', 'null' => false),
					'mail_sendable' => array('type' => 'boolean', 'null' => true),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcement_notifications' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
					'notification_type' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'mail_subject' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'mail_body' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				)
			)
		),
		'down' => array(
			'drop_table' => array(
				'announcements',
				'announcements_blocks',
				'announcement_settings',
				'announcement_part_settings',
				'announcement_notifications',
			)
		)
	);

/**
 * recodes
 *
 * @var array $migration
 */
	public $records = array(
			'announcements' => array(
				array (
					'id' => 1,
					'announcements_block_id' => '1',
					'status' => '1',
					'language_id' => '2',
					'is_auto_translation' => '1',
					'translation_engine' => null,
					'content' => '<div class="jumbotron">
<h1 class="text-center">NetCommons 3!</h1>
<p><a class="btn btn-primary btn-lg container" href="setting">セッティングモードで編集しよう<span class="glyphicon glyphicon-pencil">.</span></a></p>
ようこそ NetCommons3へ！<br /> NetCommons3は国立情報学研究所が次世代情報共有基盤システムとして開発したCMSです。</div>',
					'created' => '2014-06-10 23:54:27',
					'created_user' => 1,
				)
			),
			'announcements_blocks' => array(
				array (
					'id' => 1,
					'block_id' => 1,
					'created' => '2014-06-10 23:54:27',
					'created_user' => 1
				),
				array (
					'id' => 2,
					'block_id' => 2,
					'created_user' => 1,
					'created' => '2014-06-10 23:54:27'
				),
				array (
					'id' => 3,
					'block_id' => 3,
					'created_user' => 1,
					'created' => '2014-06-10 23:54:27'
				),
				array (
					'id' => 4,
					'block_id' => 4,
					'created_user' => 1,
					'created' => '2014-06-10 23:54:27'
				),
				array (
					'id' => 5,
					'block_id' => 5,
					'created_user' => 1,
					'created' => '2014-06-10 23:54:27'
				),
			),
			'announcement_part_settings' => array(
				array(
					'id' => 1,
					'block_id' => 1,
					'part_id' => 1,
					'readable_content' => true,
					'editable_content' => true,
					'createable_content' => true,
					'publishable_content' => true,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				),
				array(
					'id' => 2,
					'block_id' => 1,
					'part_id' => 2,
					'readable_content' => true,
					'editable_content' => false,
					'createable_content' => true,
					'publishable_content' => false,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				),
				array(
					'id' => 3,
					'block_id' => 1,
					'part_id' => 3,
					'readable_content' => true,
					'editable_content' => false,
					'createable_content' => true,
					'publishable_content' => false,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				),
				array(
					'id' => 4,
					'block_id' => 1,
					'part_id' => 4,
					'readable_content' => true,
					'editable_content' => false,
					'createable_content' => true,
					'publishable_content' => false,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				),
				array(
					'id' => 5,
					'block_id' => 1,
					'part_id' => 5,
					'readable_content' => true,
					'editable_content' => false,
					'createable_content' => false,
					'publishable_content' => false,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				),
				array(
					'id' => 6,
					'block_id' => 2,
					'part_id' => 1,
					'readable_content' => true,
					'editable_content' => true,
					'createable_content' => true,
					'publishable_content' => true,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				),
				array(
					'id' => 7,
					'block_id' => 2,
					'part_id' => 2,
					'readable_content' => true,
					'editable_content' => false,
					'createable_content' => true,
					'publishable_content' => false,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				),
				array(
					'id' => 8,
					'block_id' => 2,
					'part_id' => 3,
					'readable_content' => true,
					'editable_content' => false,
					'createable_content' => true,
					'publishable_content' => false,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				),
				array(
					'id' => 9,
					'block_id' => 2,
					'part_id' => 4,
					'readable_content' => true,
					'editable_content' => false,
					'createable_content' => true,
					'publishable_content' => false,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				),
				array(
					'id' => 10,
					'block_id' => 2,
					'part_id' => 5,
					'readable_content' => true,
					'editable_content' => false,
					'createable_content' => false,
					'publishable_content' => false,
					'mail_sendable' => false,
					'created' => '2014-08-23 09:16:52',
					'created_user' => 1,
					'modified' => '2014-08-23 09:16:52',
					'modified_user' => 1
				)
			)
	);

/**
 * Before migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return boolean Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return boolean Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}

		return true;
	}

/**
 * Update model records
 *
 * @param string $model model name to update
 * @param string $records records to be stored
 * @param string $scope ?
 * @return boolean Should process continue
 */
	public function updateRecords($model, $records, $scope = null) {
		$Model = $this->generateModel($model);
		foreach ($records as $record) {
			$Model->create();
			if (!$Model->save($record, false)) {
				return false;
			}
		}

		return true;
	}

}
