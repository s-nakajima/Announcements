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
				'announcement_data' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'announcement_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'status_id' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
					'is_original' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcements' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcement_block_setting' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'is_send_request' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'is_send_update' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
						),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'announcement_block_parts' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'part_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'read_content' => array('type' => 'integer', 'length' => 2, 'null' => false, 'default' => '0'),
					'edit_content' => array('type' => 'integer', 'length' => 2, 'null' => false, 'default' => '0'),
					'create_content' => array('type' => 'integer', 'length' => 2, 'null' => false, 'default' => '0'),
					'publish_content' => array('type' => 'integer', 'length' => 2, 'null' => false, 'default' => '0'),
					'is_send' => array('type' => 'integer', 'length' => 1, 'null' => false, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
						),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),

				),
				'announcement_block_message' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
					'type_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'subject' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'body' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'create_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
						),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			)
		),
		'down' => array(
			'drop_table' => array(
				'announcement_data',
				'announcements',
				'announcement_block_setting',
				'announcement_block_parts',
				'announcement_block_message'
			)
		)
	);

/**
 * recodes
 *
 * @var array $migration
 */
	public $records = array(
			'AnnouncementDatum' => array(
				array (
					'id' => 1,
					'announcement_id' => '1',
					'status_id' => '1',
					'language_id' => '2',
					'is_original' => '1',
					'translation_engine' => null,
					'content' => '<div class="jumbotron">
<h1 class="text-center">NetCommons 3!</h1>
<p><a class="btn btn-primary btn-lg container" href="setting">セッティングモードで編集しよう<span class="glyphicon glyphicon-pencil">.</span></a></p>
ようこそ NetCommons3へ！<br /> NetCommons3は国立情報学研究所が次世代情報共有基盤システムとして開発したCMSです。</div>',
					'created' => '2014-06-11 14:41:42',
					'create_user_id' => '1',
					'modified' => '2014-06-11 14:41:42',
					'modified_user_id' => '0',
				)
			),
			'Announcements' => array(
				array (
					'id' => 1,
					'block_id' => '1',
					'created' => '2014-06-10 23:54:27',
					'create_user_id' => '1',
					'modified' => '2014-06-10 23:54:27',
					'modified_user_id' => '0',
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
