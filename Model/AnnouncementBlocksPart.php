<?php
/**
 * AnnouncementBlocksPart Model
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * AnnouncementBlocksPart Model
 */
class AnnouncementBlocksPart extends AnnouncementsAppModel {

/**
 * construct
 * @param boolean|integer|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @return  void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'announcement_block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'required' => true,
					'allowEmpty' => false,
					'message' => __('The input must be a number.')
				)
			),
			'part_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'required' => true,
					'allowEmpty' => false,
					'message' => __('The input must be a number.')
				)
			),
			'can_edit_content' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'last' => true,
					'required' => true,
					'message' => __('The input must be a boolean.')
				)
			),
			'can_publish_content' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'last' => true,
					'required' => true,
					'message' => __('The input must be a boolean.')
				)
			),
			'can_send_mail' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'last' => true,
					'required' => true,
					'message' => __('The input must be a boolean.')
				)
			),
		);
	}

/**
 * 初期データ作成
 *
 * @param integer $announcementBlockId
 * @return array
 * @access public
 */
	public function findByAnnouncementBlockIdOrDefault($announcementBlockId) {
		$data = $this->findAllByAnnouncementBlockId($announcementBlockId);

		if (count($data) == 0) {
			$data = $this->__generateArray($announcementBlockId);
		} else {
			$data = $this->__flipArray($data);
		}
		return $data;
	}

/**
 * 初期データ作成
 * announcement_block_id,part_idより1件取得
 *
 * @param integer $announcementBlockId
 * @param integer $partId
 * @return array
 * @access public
 */
	public function findByKeysOrDefault($announcementBlockId, $partId) {
		$data = $this->find('first',
			array('conditions' => array(
				'announcement_block_id' => $announcementBlockId,
				'part_id' => $partId
			)));

		if (count($data) == 0) {
			$data = $this->__generateRecord($announcementBlockId, $partId);
		}
		return $data;
	}

/**
 * 初期データを取得する。
 *
 * @param integer $announcementBlockId
 * @return array
 * @access private
 */
	private function __generateArray($announcementBlockId) {
		$data = array(
			$this->alias => array(),
		);
		$RoomPart = ClassRegistry::init('RoomPart');
		$roomParts = $RoomPart->find('all');

		foreach ($roomParts as $key => $roomPart) {
			$canSendMail = false;
			if ($roomPart[$RoomPart->alias]['can_edit_page']) {
				// 投稿をメールで通知する範囲のデフォルト値は、ページの編集権限で決定
				$canSendMail = true;
			}
			$data[$this->alias][$key] = array(
				'id' => 0,
				'announcement_block_id' => $announcementBlockId,
				'part_id' => $roomPart[$RoomPart->alias]['part_id'],
				'can_edit_content' => $roomPart[$RoomPart->alias]['can_edit_content'],
				'can_publish_content' => $roomPart[$RoomPart->alias]['can_publish_content'],
				'can_send_mail' => $canSendMail,
			);
		}

		return $data;
	}

/**
 * 初期データを取得する。
 *
 * @param integer $announcementBlockId
 * @param integer $partId
 * @return array
 * @access private
 */
	private function __generateRecord($announcementBlockId, $partId) {
		$RoomPart = ClassRegistry::init('RoomPart');

		$roomPart = $RoomPart->find('first',
			array('conditions' => array(
				'part_id' => $partId
			)));

		if ($roomPart[$RoomPart->alias]['can_edit_page']) {
			// 投稿をメールで通知する範囲のデフォルト値は、ページの編集権限で決定
			$canSendMail = true;
		}
		$data[$this->alias] = array(
			'id' => 0,
			'announcement_block_id' => $announcementBlockId,
			'part_id' => $roomPart[$RoomPart->alias]['part_id'],
			'can_edit_content' => $roomPart[$RoomPart->alias]['can_edit_content'],
			'can_publish_content' => $roomPart[$RoomPart->alias]['can_publish_content'],
			'can_send_mail' => $canSendMail,
		);
		return $data;
	}

/**
 * 配列のキーと値を反転する。
 *
 * @param array $data
 * @return array
 * @access private
 */
	private function __flipArray($data) {
		$bufData = array();
		foreach ($data as $key => $values) {
			foreach ($values as $modelName => $valueArray) {
				$bufData[$modelName][$key] = $valueArray;
			}
		}
		return $bufData;
	}

}
