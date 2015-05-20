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
 * Migration CakeMigration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Config\Migration
 */
class AddLanguageIdToAnnouncements extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_language_id_to_announcements';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'announcements' => array(
					'is_first_auto_translation' => array('type' => 'boolean', 'null' => false, 'after' => 'content'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'after' => 'id'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'announcements' => array('language_id', 'is_first_auto_translation'),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
