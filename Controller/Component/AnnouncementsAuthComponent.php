<?php
/**
 * AnnouncementsAuth Component
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AuthComponent', 'Controller/Component');

class AnnouncementsAuthComponent extends Component {

/**
 * Components used
 *
 * @var array
 */
	public $components = array('AuthComponent');

/**
 * _controller
 *
 * @var Controller
 */
	protected $_controller = null;

/**
 * Constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings.
 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->_controller = $collection->getController();
		parent::__construct($collection, $settings);
	}

/**
 * canReadContent
 * コンテンツを読めるかどうか
 *
 * @param   integer $blockId
 * @param   integer $userId default グインID
 * @return  boolean
 */
	public function canReadContent($blockId, $userId = 0) {
		// TODO: 現状、パブリックスペースのみの対応のため未実装。
		return true;
	}

/**
 * canEditContent
 * コンテンツを編集できるかどうか
 *
 * @param   integer $blockId
 * @param   integer $userId default ログインID
 * @return  boolean
 */
	public function canEditContent($blockId, $userId = 0) {
		$roomPart = $this->_findRoomPartByBlockId($blockId, $userId);
		if (!$roomPart) {
			return false;
		}
		$announcementBlock = $this->_controller->AnnouncementBlock->findByAuthOrDefault($blockId, $roomPart['RoomPart']['part_id']);
		return ($roomPart['RoomPart']['can_read_content'] && $announcementBlock['AnnouncementBlocksPart']['can_edit_content']) ? true : false;
	}

/**
 * canEditBlock
 * コンテンツを編集できるかどうか
 *
 * @param   integer $blockId
 * @param   integer $userId default ログインID
 * @return  boolean
 */
	public function canEditBlock($blockId, $userId = 0) {
		$roomPart = $this->_findRoomPartByBlockId($blockId, $userId);
		if (!$roomPart) {
			return false;
		}
		return ($roomPart['RoomPart']['can_read_block'] && $roomPart['RoomPart']['can_edit_block']) ? true : false;
	}

/**
 * _findRoomPartByBlockId
 * 共通のModelの処理へ移動するべき。
 * 現在のuser_idにおけるブロックのPartテーブルの編集権限を取得
 * block_idからroom_idを求め、user_id,room_idからpart_idを求め
 * room_parts.can_xxxx(can_edit_block等)を見て判断。
 *
 * @param   integer $blockId
 * @param   integer $userId default ログインID
 * @return  mixed array $roomPart or boolean false
 */
	protected function _findRoomPartByBlockId($blockId, $userId = 0) {
		if (!$userId) {
			$user = $this->_controller->Auth->user();
			if (!$user) {
				return false;
			}
			$userId = $user['id'];
		}

		$roomPart = $this->_controller->Block->find('first', array(
			'fields' => array('RoomPart.*'),
			'recursive' => -1,
			'conditions' => array('Block.id' => $blockId),
			'joins' => array(
				array(
					"type" => "INNER",
					"table" => "parts_rooms_users",
					"alias" => "PartsRoomsUser",
					"conditions" => array(
						'PartsRoomsUser.room_id = Block.room_id',
						'PartsRoomsUser.user_id' => $userId
					)
				),
				array(
					"type" => "INNER",
					"table" => "room_parts",
					"alias" => "RoomPart",
					"conditions" => array(
						'RoomPart.part_id = PartsRoomsUser.part_id'
					)
				),
			),
		));

		if (!isset($roomPart['RoomPart'])) {
			return false;
		}
		return $roomPart;
	}

}
