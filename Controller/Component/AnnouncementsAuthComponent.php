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
		// TestCode 現状、パブリックスペースのみの対応のため未実装。
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
		$userId = $this->_getUserId($userId);
		$roomPart = $this->_controller->Block->findRoomPartByBlockId($blockId, $userId);
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
		$userId = $this->_getUserId($userId);
		$roomPart = $this->_controller->Block->findRoomPartByBlockId($blockId, $userId);
		if (!$roomPart) {
			return false;
		}
		return ($roomPart['RoomPart']['can_read_block'] && $roomPart['RoomPart']['can_edit_block']) ? true : false;
	}

/**
 * _getUserId
 * paramが空ならば、loginIDセット
 *
 * @param   integer $userId
 * @return  integer $userId
 */
	protected function _getUserId($userId = 0) {
		if (!$userId) {
			$user = $this->_controller->Auth->user();
			if (!$user) {
				return false;
			}
			$userId = $user['id'];
		}
		return $userId;
	}

}
