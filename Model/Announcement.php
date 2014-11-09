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
 * comment text length
 *
 * @var int
 */
	const COMMENT_LENGTH = 34;

/**
 * comment text length
 *
 * @var int
 */
	const NICKNAME_LENGTH = 15;

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
				'range' => array(
					'rule' => array('range', 0, 5),
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
					'required' => true,
				)
			),
		);

		//ステータス 差し戻しのみコメント必須
		if ($this->data['Announcement']['status'] === NetCommonsBlockComponent::STATUS_DISAPPROVED) {
			$this->validate['comment'] = array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('net_commons', 'Comment')),
					'required' => true,
				),
			);
		}

		return parent::beforeValidate($options);
	}

/**
 * get content data
 *
 * @param int $blockId blocks.id
 * @param bool $contentEditable true can edit the content, false not can edit the content.
 * @return array
 */
	public function getAnnouncement($blockId, $contentEditable) {
		$conditions = array(
			'block_id' => $blockId,
		);
		if (! $contentEditable) {
			$conditions['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
		}

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

		return $announcement;
	}

/**
 * save announcement
 *
 * @param array $postData received post data
 * @return bool true success, false error
 * @throws InternalErrorException
 */
	public function saveAnnouncement($postData) {
		//DBへの登録
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			$block = $this->Block->saveByFrameId($postData['Frame']['id']);
			if (! $block) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$count = $this->find('count', array(
				'conditions' => array('block_id' => (int)$block['Block']['id'])
			));
			if ($count === 0) {
				//announcementsテーブルのkey生成
				$postData['Announcement']['key'] = hash('sha256', 'announcement_' . microtime());
			}

			unset($postData['Announcement']['id']);
			$announcement = $this->create();
			$announcement['Announcement'] = $postData['Announcement'];
			$announcement['Announcement']['block_id'] = (int)$block['Block']['id'];
			$announcement['Announcement']['created_user'] = CakeSession::read('Auth.User.id');
			$announcement = $this->save($announcement);
			if (! $announcement) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$dataSource->commit();
			return $announcement;

		} catch (Exception $ex) {
			$dataSource->rollback();
			return false;
		}
	}
}
