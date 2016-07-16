<?php
/**
 * Announcement Model
 *
 * @property Block $Block
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
 * Announcement Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Model
 */
class Announcement extends AnnouncementsAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.Block' => array(
			'name' => 'Announcement.content',
		),
		'NetCommons.OriginalKey',
		'Workflow.WorkflowComment',
		'Workflow.Workflow',
		'Mails.MailQueue' => array(
			'embedTags' => array(
				'X-BODY' => 'Announcement.content',
			),
		),
		'Topics.Topics' => array(
			'fields' => array(
				'title' => 'Announcement.content',
				'summary' => 'Announcement.content',
			),
		),
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
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
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					//'allowEmpty' => true,
					//'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				)
			),

			//key to set in OriginalKeyBehavior.

			//status to set in WorkflowBehavior.

			'content' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('announcements', 'Content')),
					'required' => true
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @throws InternalErrorException
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 */
	public function afterSave($created, $options = array()) {
		$this->loadModels([
			'AnnouncementSetting' => 'Announcements.AnnouncementSetting',
		]);

		//AnnouncementSetting登録
		if (isset($this->data['AnnouncementSetting'])) {
			if (! $this->data['AnnouncementSetting']['id']) {
				$this->data['AnnouncementSetting']['id'] = $this->data['Block']['id'];
			}
			$this->AnnouncementSetting->set($this->data['AnnouncementSetting']);
			if (! $this->AnnouncementSetting->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		parent::afterSave($created, $options);
	}

/**
 * Get announcement data
 *
 * @return array
 */
	public function getAnnouncement() {
		$this->loadModels([
			'AnnouncementSetting' => 'Announcements.AnnouncementSetting',
		]);

		if (Current::permission('content_editable')) {
			$conditions[$this->alias . '.is_latest'] = true;
		} else {
			$conditions[$this->alias . '.is_active'] = true;
		}
		$announcement = $this->find('first', array(
			'recursive' => 0,
			'conditions' => $this->getBlockConditionById($conditions),
		));

		return Hash::merge($announcement, $this->AnnouncementSetting->getAnnouncementSetting());
	}

/**
 * Save announcement
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveAnnouncement($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			//お知らせの登録
			$announcement = $this->save(null, false);
			if (! $announcement) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return $announcement;
	}

/**
 * Delete Announcement
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteAnnouncement($data) {
		//トランザクションBegin
		$this->begin();

		try {
			//Announcementの削除
			$this->contentKey = $data[$this->alias]['key'];
			$conditions = array($this->alias . '.key' => $data[$this->alias]['key']);
			if (! $this->deleteAll($conditions, false, true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Blockデータ削除
			$this->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}
}
