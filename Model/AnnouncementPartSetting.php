<?php
/**
 * AnnouncementPartSetting Model
 *
 * @property Block $Block
 * @property Part $Part
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * Summary for AnnouncementPartSetting Model
 */
class AnnouncementPartSetting extends AnnouncementsAppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

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
		'part_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'editable_content' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'publishable_content' => array(
			'boolean' => array(
				'rule' => array('boolean'),
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
		'Part' => array(
			'className' => 'Part',
			'foreignKey' => 'part_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * get a setting of blocks (all parts)
 * 
 * @param int $blockId blocks.id
 * @return array
 */
	public function getList($blockId) {
		$rtn = $this->find('all', array(
			'conditions' => array(
				$this->name . '.block_id' => $blockId
			),
			'fields' => array($this->name . '.*')
		));
		return $rtn;
	}

/**
 * get recode
 * 
 * @param int $blockId blocks.id
 * @param int $partId parts.id
 * @return array
 */
	public function get($blockId, $partId) {
		$rtn = $this->find('first', array(
			'conditions' => array(
				$this->name . '.block_id' => $blockId,
				$this->name . '.part_id' => $partId
			)
		));
		return $rtn;
	}

/**
 * Array of part_id settings block
 * 
 * @param int $blockId blocks.id
 * @return array
 */
	public function getListPartIdArray($blockId) {
		$list = $this->getList($blockId);
		$rtn = array();
		foreach ((array)$list as $item) {
			$partId = $item[$this->name]['part_id'];
			$rtn[$partId] = $item[$this->name];
		}
		return $rtn;
	}

/**
 * get id by blockId
 * 
 * @param int $blockId blocks.id
 * @param int $partId parts.id
 * @return int|null
 */
	public function getIdByBlockId($blockId, $partId) {
		$block = $this->get($blockId, $partId);
		if ($block &&
			isset($block[$this->name]['id']) &&
			$block[$this->name]['id']
		) {
			return $block[$this->name]['id'];
		}
		return null;
	}

}
