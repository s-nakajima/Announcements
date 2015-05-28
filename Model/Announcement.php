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
App::uses('Search', 'Search.Utility');

/**
 * Announcement Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Model
 */
class Announcement extends AnnouncementsAppModel {

/**
 * Max length of content
 *
 * @var int
 */
	const LIST_TITLE_LENGTH = 50;

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
		'NetCommons.Publishable'
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
					'allowEmpty' => true,
					//'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				)
			),

			//key to set in OriginalKeyBehavior.

			//status to set in PublishableBehavior.

			'is_auto_translated' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
			'is_first_auto_translation' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
			'content' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('announcements', 'Content')),
					'required' => true
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get announcement data
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms.id
 * @param bool $contentEditable true can edit the content, false not can edit the content.
 * @return array
 */
	public function getAnnouncement($blockId, $roomId, $contentEditable) {
		$conditions = array(
			'Block.id' => $blockId,
			'Block.room_id' => $roomId,
		);
		if ($contentEditable) {
			$conditions[$this->alias . '.is_latest'] = true;
		} else {
			$conditions[$this->alias . '.is_active'] = true;
		}

		$announcement = $this->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
			//'order' => 'Announcement.id DESC',
		));

		return $announcement;
	}

/**
 * Save announcement
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveAnnouncement($data) {
		$this->loadModels([
			'Announcement' => 'Announcements.Announcement',
			'Block' => 'Blocks.Block',
			'Comment' => 'Comments.Comment',
			'Topic' => 'Topics.Topic',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (!$this->validateAnnouncement($data, ['block', 'comment'])) {
				return false;
			}

			//ブロックの登録
			$block = $this->Block->saveByFrameId($data['Frame']['id']);

			//お知らせの登録
			$this->data['Announcement']['block_id'] = (int)$block['Block']['id'];
			$announcement = $this->save(null, false);
			if (! $announcement) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//コメントの登録
			if ($this->Comment->data) {
				$this->Comment->data[$this->Comment->name]['block_key'] = $block['Block']['key'];
				$this->Comment->data[$this->Comment->name]['content_key'] = $announcement[$this->alias]['key'];
				if (! $this->Comment->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			$plugin = strtolower($this->plugin);
			if (!$this->Topic->validateTopic([
				'status' => $announcement[$this->alias]['status'],
				'is_active' => $announcement[$this->alias]['is_active'],
				'is_latest' => $announcement[$this->alias]['is_latest'],
				'is_auto_translated' => $announcement[$this->alias]['is_auto_translated'],
				'is_first_auto_translation' => $announcement[$this->alias]['is_first_auto_translation'],
				'translation_engine' => $announcement[$this->alias]['translation_engine'],
				//'title' => Search::prepareTitle($announcement[$this->alias]['content']),
				//'contents' => Search::prepareContents([$announcement[$this->alias]['content']]),
				'plugin_key' => $plugin,
				'path' => $plugin . '/' . $plugin . '/view/' . $data['Frame']['id'],
			])) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Topic->validationErrors);
				return false;
			}
			if (! $this->Topic->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return $announcement;
	}

/**
 * validate announcement
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on error
 */
	public function validateAnnouncement($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}

		if (in_array('comment', $contains, true) && isset($data['Comment'])) {
			if (! $this->Comment->validateByStatus($data, array('plugin' => $this->plugin, 'caller' => $this->name))) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
				return false;
			}
		}

		if (in_array('block', $contains, true)) {
			//ブロックのvalidate
			if (! $this->Block->validateBlock($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Block->validationErrors);
				return false;
			}
		}

		return true;
	}

/**
 * Delete Announcement
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteAnnouncement($data) {
		$this->loadModels([
			'Announcement' => 'Announcements.Announcement',
			'Block' => 'Blocks.Block',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//Announcementの削除
			if (! $this->deleteAll(array($this->alias . '.key' => $data[$this->alias]['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//コメントの削除
			$this->Comment->deleteByBlockKey($data['Block']['key']);

			//Blockデータ削除
			$this->Block->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

}
