<?php
/**
 * AnnouncementPartSetting Model
 *
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');
App::uses('Frame', 'Model');
App::uses('RoomPart', 'Model');

/**
 * Summary for AnnouncementBlockPart Model
 */
class AnnouncementPartSetting extends AppModel {

/**
 * changeable value  room_parts
 *
 * @var array
 */
	const CHANGEABLE_PART_VALUE = 2;

/**
 * cannot change value  room_parts
 *
 * @var int
 */
	const CANNOT_PART_VALUE = 0;

/**
 * validate
 *
 * @var array
 */
	public $validate = array(
		'created_user' => array(
			'rule' => array('numeric')
		),
		'modified_user' => array(
			'rule' => array('numeric'),
		),
		'block_id' => array(
			'rule' => array(
				'numeric',
				'notEmpty'
			)
		),
		'part_id' => array(
			'rule' => array(
				'numeric',
				'notEmpty',
				'required'
			)
		)
	);

/**
 * belongsTo
 *
 * @var string
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

/**
 * part_id of changeable role
 *
 * @param string $colName room_parts column name
 * @return array
 */
	public function changeablePartList($colName) {
		//RoomPartから取得
		$this->RoomPart = Classregistry::init('RoomPart');
		$roomPartList = $this->RoomPart->find('all', array(
			'conditions' => array(
				$this->RoomPart->name . '.' . $colName => self::CHANGEABLE_PART_VALUE
			),
			'fields' => array(
				$this->RoomPart->name . '.part_id',
				$this->RoomPart->name . '.' . $colName,
			)
		));
		$rtn = array();
		foreach ($roomPartList as $roomPart) {
			$rtn[] = $roomPart[$this->RoomPart->name]['part_id'];
		}
		return $rtn;
	}
}
