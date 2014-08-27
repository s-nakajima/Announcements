<?php
/**
 * Announcement Model
 *
 * @property AnnouncementsBlock $AnnouncementsBlock
 * @property Language $Language
 * @property Block $Block
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * Summary for Announcement Model
 */
class Announcement extends AnnouncementsAppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * Announcements status publish
 *
 * @var int
 */
	const STATUS_PUBLISH = 1;

/**
 * Announcements status publish
 *
 * @var int
 */
	const STATUS_PUBLISH_REQUEST = 2;

/**
 * Announcements status Draft
 *
 * @var int
 */
	const STATUS_DRAFT = 3;
/**
 * Announcements status Reject
 *
 * @var int
 */
	const STATUS_REJECT = 4;

/**
 * Announcements status array.
 *
 * @var array
 */
	private $__statusList = array(
		'Publish' => 1,
		'PublishRequest' => 2,
		'Draft' => 3,
		'Reject' => 4
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'announcements_block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'language_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'translation_engine' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		//'content' => array(
			//'maxLength' => array(
				//'rule' => array('maxLength'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		//),
		'modified_user' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AnnouncementsBlock' => array(
			'className' => 'Announcements.AnnouncementsBlock',
			'foreignKey' => 'announcements_block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * the latest content data
 *
 * @param int $blockId blocks.id
 * @param string $langId language_id
 * @param int $all  status publish only
 * @return array
 */
	public function getContent($blockId, $langId, $all = 0) {
		$conditions = array(
			'block_id' => $blockId,
			'language_id' => $langId,
			'status' => self::STATUS_PUBLISH
		);
		if ($all) {
			unset($conditions['status']);
		}
		return $this->find('first', array(
			'conditions' => $conditions,
			'order' => $this->name . '.id DESC',
		));
	}

/**
 * save content data
 *
 * @param array $data received post data
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @param int $encoded 1:encoded 0:not encoded
 * @return array
 */
	public function saveContent($data, $frameId, $blockId, $encoded = 'encoded') {
		//frameID chaeck
		if (! isset($data[$this->name]['frameId']) ||
			$frameId !== $data[$this->name]['frameId']) {
			return array();
		}
		//decode
		if ($encoded) {
			$data[$this->name]['content'] = rawurldecode($data[$this->name]['content']);
		}

		//status
		if (isset($this->__statusList[$data[$this->name]['status']])) {
			$status = intval($this->__statusList[$data[$this->name]['status']]);
		}
		//master
		$this->AnnouncementsBlock->setDataSource('master');
		$this->setDataSource('master');
		$announcementsBlockId = $this->AnnouncementsBlock->getAnnouncementsBlockId($frameId, $blockId);

		$this->create();
		$rtn = $this->save(array(
			'announcements_block_id' => $announcementsBlockId,
			'create_user_id' => CakeSession::read('Auth.User.id'),
			'language_id' => $data[$this->name]['langId'],
			'status' => $status,
			'content' => $data[$this->name]['content'],
			'created_user' => CakeSession::read('Auth.User.id')
		));
		if (!$rtn) {
			return array();
		}
		return $this->getContent($blockId, $data[$this->name]['langId'], 1);
	}

}
