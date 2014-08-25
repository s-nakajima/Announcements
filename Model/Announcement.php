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
	protected $_status = array(
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
			'className' => 'AnnouncementsBlock',
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
 * 最新のデータを取得する
 *
 * @param int $blockId blocks.id
 * @param string $langId language_id
 * @param bool $publishOnly get only publish status
 * @return array
 */
	public function get($blockId, $langId, $publishOnly = '') {
		$conditions = array(
			'block_id' => $blockId,
			'language_id' => $langId,
		);
		if ($publishOnly) {
			$conditions['status'] = self::STATUS_PUBLISH;
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
		//frameIdと、dataの中で指定されたものが同じかどうかのチェック
		if ($frameId != $data[$this->name]['frameId']) {
			return array();
		}
		//decodeする
		if ($encoded) {
			$data[$this->name]['content'] = rawurldecode($data[$this->name]['content']);
		}

		//statusを数字に変換
		if (isset($this->_status[$data[$this->name]['status']])) {
			$status = intval($this->_status[$data[$this->name]['status']]);
		}
		//masterに接続
		$this->AnnouncementsBlock->setDataSource('master');
		$this->setDataSource('master');

		//announcementsBlockId 取得
		$announcementsBlockId = $this->getAnnouncementsBlockId($blockId);

		//保存
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
		return $this->get($blockId, $data[$this->name]['langId']);
	}

/**
 *  get announcements_blocks.block_id by blockId
 *
 * @param int $blockId blocks.id
 * @return int || null
 */
	public function getAnnouncementsBlockId($blockId) {
		$col = $this->AnnouncementsBlock->name;
		$rtn = $this->AnnouncementsBlock->find(
			'first',
			array(
				'conditions' => array($col . '.block_id' => $blockId)
			)
		);
		if (isset($rtn[$col]['id'])) {
			return $rtn[$col]['id'];
		}
		//作成
		$this->AnnouncementsBlock->create();
		$this->AnnouncementsBlock->save(array(
			'block_id' => $blockId,
			'created_user' => CakeSession::read('Auth.User.id'),
		));
		return $this->getAnnouncementsBlockId($blockId);
	}

}
