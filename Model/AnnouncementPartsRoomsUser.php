<?php
/**
 * PartsRoomsUser Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for PartsRoomsUser Model
 */
class AnnouncementPartsRoomsUser extends AppModel {

/**
 * テーブルの指定
 *
 * @var bool
 */
	public $useTable = 'parts_rooms_users';

/**
 * useridから、ルーム内のパートの情報を取得する。
 *
 * @param int $roomId rooms.id
 * @param int $userId users.id
 * @return array
 */
	public function getRoomPart($roomId, $userId) {
		//どちらかがないなら、
		if (! $roomId || !$userId) {
			return array();
		}
		$rtn = $this->find('first', array(
				'joins' => array(
					array(
						'type' => 'LEFT',
						'table' => 'room_parts',
						'alias' => 'RoomPart',
						'conditions' => array(
							$this->name . '.user_id' => $userId,
							$this->name . '.room_id' => $roomId,
							'RoomPart.part_id=' . $this->name . '.part_id'
						)
					)
				),
				'fields' => array(
					$this->name . '.*',
					'RoomPart.*'
				)
			)
		);
		return $rtn;
	}
}
