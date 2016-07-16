<?php
/**
 * AnnouncementSetting Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');
App::uses('BlockSettingBehavior', 'Blocks.Model/Behavior');

/**
 * AnnouncementSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Model
 */
class AnnouncementSetting extends AnnouncementsAppModel {

/**
 * Custom database table name
 *
 * @var string
 */
	public $useTable = 'blocks';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.BlockRolePermission',
		'Blocks.BlockSetting' => array(
			BlockSettingBehavior::FIELD_USE_WORKFLOW,
		),
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'language_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
			),
			'room_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * AnnouncementSettingデータ新規作成
 *
 * @return array
 */
	public function createAnnouncementSetting() {
		$announcementSetting = $this->createAll();
		/** @see BlockSettingBehavior::getBlockSetting() */
		/** @see BlockSettingBehavior::_createBlockSetting() */
		return Hash::merge($announcementSetting, $this->getBlockSetting());
	}

/**
 * AnnouncementSettingデータ取得
 *
 * @return array
 */
	public function getAnnouncementSetting() {
		$announcementSetting = $this->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				$this->alias . '.key' => Current::read('Block.key'),
				$this->alias . '.language_id' => Current::read('Language.id'),
			),
		));

		return $announcementSetting;
	}

/**
 * AnnouncementSettingデータ登録
 *
 * @param array $data リクエストデータ
 * @return bool
 * @throws InternalErrorException
 */
	public function saveAnnouncementSetting($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
