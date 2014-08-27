<?php
/**
 * AnnouncementsBlock Model
 *
 * @property Block $Block
 * @property Announcement $Announcement
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * Summary for AnnouncementsBlock Model
 */
class AnnouncementsBlock extends AnnouncementsAppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created_user' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Frame' => array(
			'className' => 'Frames.Frame',
			'foreignKey' => 'block_id',
			'conditions' => 'Frame.block_id=Block.id',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Announcement' => array(
			'className' => 'Announcement',
			'foreignKey' => 'announcements_block_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 *  get announcements_blocks.block_id by blockId
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return int || null
 */
	public function getAnnouncementsBlockId($frameId, $blockId) {
		if (! $blockId) {
			//master
			$this->Frame->setDataSource('master');
			$this->Block->setDataSource('master');
			$this->setDataSource('master');
			$rtn = $this->Frame->findById($frameId);

			$blockId = $rtn[$this->Frame->name]['block_id'];
			if (! $blockId) {
				$blockId = $this->Block->addBlock($frameId);
			}
		}
		$rtn = $this->find(
			'first',
			array(
				'conditions' => array($this->name . '.block_id' => $blockId)
			)
		);
		if (isset($rtn[$this->name]['id'])) {
			return $rtn[$this->name]['id'];
		}
		return $this->createByBlock($blockId);
	}

/**
 * create
 *
 * @param int $blockId blocks.int
 * @return null | int
 */
	public function createByBlock($blockId) {
		$this->create();
		$this->setDataSource('master');
		$this->create();
		$rtn = $this->save(array(
			'block_id' => $blockId,
			'created_user' => CakeSession::read('Auth.User.id'),
		));
		if (isset($rtn[$this->name]['id'])) {
			return $rtn[$this->name]['id'];
		}
		return null;
	}

}
