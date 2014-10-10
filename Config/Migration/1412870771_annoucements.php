<?php
/**
 * Migration file
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * AccessCounters CakeMigration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Config\Migration
 */
class Annoucements extends CakeMigration {

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
			),
			'create_field' => array(
				'announcements' => array(
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'after' => 'id'),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'announcement content key | お知らせコンテンツキー | Hash値 | ', 'charset' => 'utf8', 'after' => 'block_id'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | ', 'after' => 'content'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | ', 'after' => 'translation_engine'),
				),
			),
			'drop_field' => array(
				'announcements' => array('announcements_block.id', 'language_id', 'is_auto_translation', 'create_user',),
			),
			'alter_field' => array(
				'announcements' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
					'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'content | コンテンツ |  | ', 'charset' => 'utf8'),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
				),
			),
			'drop_table' => array(
				'announcements_blocks', 'announcement_setting', 'announcement_part_settings', 'announcement_notification'
			),
		),
		'down' => array(
			'drop_table' => array(
			),
			'drop_field' => array(
				'announcements' => array('block_id', 'key', 'is_auto_translated', 'created_user',),
			),
			'create_field' => array(
				'announcements' => array(
					'announcements_block.id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
					'is_auto_translation' => array('type' => 'boolean', 'null' => true),
					'create_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
				),
			),
			'alter_field' => array(
				'announcements' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
				),
			),
			'create_table' => array(
				'announcements_blocks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcement_setting' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'sendable_request' => array('type' => 'boolean', 'null' => true),
					'sendable_update' => array('type' => 'boolean', 'null' => true),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
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
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcement_notification' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
					'notification_type' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'mail_subject' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'mail_body' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
	);

/**
 * recodes
 *
 * @var array $migration
 */
	public $records = array();

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
