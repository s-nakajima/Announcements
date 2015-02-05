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
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
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
 * Constructor. Binds the model's database table to the object.
 *
 * If `$id` is an array it can be used to pass several options into the model.
 *
 * - `id`: The id to start the model on.
 * - `table`: The table to use for this model.
 * - `ds`: The connection name this model is connected to.
 * - `name`: The name of the model eg. Post.
 * - `alias`: The alias of the model, this is used for registering the instance in the `ClassRegistry`.
 *   eg. `ParentThread`
 *
 * ### Overriding Model's __construct method.
 *
 * When overriding Model::__construct() be careful to include and pass in all 3 of the
 * arguments to `parent::__construct($id, $table, $ds);`
 *
 * ### Dynamically creating models
 *
 * You can dynamically create model instances using the $id array syntax.
 *
 * {{{
 * $Post = new Model(array('table' => 'posts', 'name' => 'Post', 'ds' => 'connection2'));
 * }}}
 *
 * Would create a model attached to the posts table on connection2. Dynamic model creation is useful
 * when you want a model object that contains no associations or attached behaviors.
 *
 * @param boolean|integer|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct();
	}

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

			//status to set in PublishableBehavior.

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
		));

		return parent::beforeValidate($options);
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

		$announcement = $this->find('first', array(
				'recursive' => -1,
				'conditions' => $conditions,
				'order' => 'Announcement.id DESC',
			)
		);

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
	public function validateAnnouncement($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? $this->validationErrors : true;
	}
}
