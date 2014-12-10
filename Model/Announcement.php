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

/**
 * Announcement Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Model
 */
class Announcement extends AnnouncementsAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	const COMMENT_PLUGIN_KEY = 'announcements';

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
		'CreatedUser' => array(
			'className' => 'Users.UserAttributesUser',
			'foreignKey' => false,
			'conditions' => array(
				'Announcement.created_user = CreatedUser.user_id',
				'CreatedUser.key' => 'nickname'
			),
			'fields' => array('CreatedUser.key', 'CreatedUser.value'),
			'order' => ''
		)
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
		$this->validate = array(
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				)
			),
			'key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				)
			),
			'status' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
				'inList' => array(
					'rule' => array('inList', NetCommonsBlockComponent::$STATUSES),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
			'is_auto_translated' => array(
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
		);

		return parent::beforeValidate($options);
	}

/**
 * before save
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if the operation should continue, false if it should abort
 */
	public function beforeSave($options = array()) {
		if (! isset($this->data[$this->name]['id'])) {
			$this->data[$this->name]['created_user'] = CakeSession::read('Auth.User.id');
		}
		$this->data[$this->name]['modified_user'] = CakeSession::read('Auth.User.id');
		return true;
	}

/**
 * get content data
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @param bool $contentEditable true can edit the content, false not can edit the content.
 * @return array
 */
	public function getAnnouncement($frameId, $blockId, $contentEditable) {
		$conditions = array(
			'block_id' => $blockId,
		);
		if (! $contentEditable) {
			$conditions['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
		}

		$this->recursive = -1;
		$announcement = $this->find('first', array(
				'conditions' => $conditions,
				'order' => 'Announcement.id DESC',
			)
		);

		if ($contentEditable && ! $announcement) {
			$announcement = $this->create();
			$announcement['Announcement']['content'] = '';
			$announcement['Announcement']['key'] = '';
			$announcement['Announcement']['id'] = '0';
		}

		if ($announcement) {
			//Commentセット
			$announcement['Comment']['comment'] = '';
			//Frameセット
			$announcement['Frame']['id'] = $frameId;
		}

		return $announcement;
	}

/**
 * save announcement
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveAnnouncement($data) {
		//モデル定義
		$this->setDataSource('master');
		$models = array(
			'Block' => 'Blocks.Block',
			'Comment' => 'Comments.Comment',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
			$this->$model->setDataSource('master');
		}

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		//validationを実行
		$ret = $this->__validateAnnouncement($data);
		if (is_array($ret)) {
			$this->validationErrors = $ret;
			return false;
		}
		$ret = $this->Comment->validateByStatus($data, array('caller' => $this->name));
		if (is_array($ret)) {
			$this->validationErrors = $ret;
			return false;
		}

		try {
			//ブロックの登録
			$block = $this->Block->saveByFrameId($data['Frame']['id'], false);

			//お知らせの登録
			$this->data['Announcement']['block_id'] = (int)$block['Block']['id'];
			$announcement = $this->save(null, false);
			if (! $announcement) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//コメントの登録
			if ($this->Comment->data) {
				if (! $this->Comment->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			//トランザクションCommit
			$dataSource->commit();
			return $announcement;

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::write(LOG_ERR, $ex);
			throw $ex;
		}
	}

/**
 * validate announcement
 *
 * @param array $data received post data
 * @return bool|array True on success, validation errors array on error
 */
	private function __validateAnnouncement($data) {
		//お知らせデータの取得
		$announcement = $this->getAnnouncement(
				(int)$data['Frame']['id'],
				(int)$data['Announcement']['block_id'],
				true
			);
		if ($announcement['Announcement']['key'] === '') {
			$data[$this->name]['key'] = Security::hash($this->name . mt_rand() . microtime(), 'md5');
		}

		//お知らせの登録
		if (! isset($data['Announcement']['content'])) {
			//定義されていない場合、Noticeが発生するため、nullで初期化
			$data['Announcement']['content'] = null;
		}
		if ($data['Announcement']['content'] !== $announcement['Announcement']['content'] ||
				$data['Announcement']['status'] !== $announcement['Announcement']['status']) {

			unset($data['Announcement']['id']);
			$announcement = $this->create();
		}
		$announcement['Announcement'] = $data['Announcement'];

		$this->set($announcement);

		$this->validates();

		return $this->validationErrors ? $this->validationErrors : true;
	}
}
