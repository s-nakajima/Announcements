<?php
/**
 * Init migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Init migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Config\Migration
 */
class Init extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'init';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'announcements' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'unsigned' => false),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'announcement content key | お知らせコンテンツキー | Hash値 | ', 'charset' => 'utf8'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
					'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Is active, 0:deactive 1:acive | アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ | | '),
					'is_latest' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Is latest, 0:not latest 1:latest | 最新コンテンツかどうか 0:最新でない 1:最新 | |'),
					'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'content | コンテンツ |  | ', 'charset' => 'utf8'),
					'is_first_auto_translation' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => null, 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'announcements'
			),
		),
	);

/**
 * records
 *
 * @var array $migration
 */
	public $records = array(
		'Announcement' => array(
			array (
				'id' => 1,
				'language_id' => '2',
				'block_id' => '1',
				'status' => '1',
				'key' => 'announcments_1',
				'is_auto_translated' => 0,
				'is_first_auto_translation' => 0,
				'is_latest' => '1',
				'is_active' => '1',
				'content' => '<div class="jumbotron">
<h1 class="text-center">NetCommons 3!</h1>
<p><a class="btn btn-primary btn-lg container" href="setting">セッティングモードで編集しよう<span class="glyphicon glyphicon-pencil">.</span></a></p>
ようこそ NetCommons3へ！<br /> NetCommons3は国立情報学研究所が次世代情報共有基盤システムとして開発したCMSです。</div>',
			),
		),

		'Plugin' => array(
			array(
				'language_id' => 2,
				'key' => 'announcements',
				'namespace' => 'netcommons/announcements',
				'name' => 'お知らせ',
				'type' => 1,
				'default_action' => 'announcements/view',
				'default_setting_action' => 'announcement_blocks/index',
			),
		),
		'PluginsRole' => array(
			array(
				'role_key' => 'room_administrator',
				'plugin_key' => 'announcements'
			),
		),
		'PluginsRoom' => array(
			array(
				'room_id' => '1',
				'plugin_key' => 'announcements'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
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
 * @return bool Should process continue
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
