<?php
/**
 * AnnouncementBlockBlock Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

class AnnouncementRoom extends AppModel {

/**
 * テーブルの指定
 * @var bool
 */
	public $useTable = 'rooms';

/**
 * name
 *
 * @var string
 */
	public $name = "AnnouncementRoom";

/**
 * __construct
 *
 * @param bool $id id
 * @param null $table db table
 * @param null $ds connection
 * @return void
 * @SuppressWarnings(PHPMD)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}

/**
 * save
 *
 * @return bool|mixed
 */
	public function save() {
		//このmodelではread onlyのためsave処理を殺しておく。
		return false;
	}

/**
 * ルーム管理者の承認が必要かどうかを取得する
 *
 * @param int $roomId rooms.id
 * @return bool
 */
	public function checkApproval($roomId) {
		$room = $this->findById($roomId);
		if (isset($room["AnnouncementRoom"])
			&& isset($room["AnnouncementRoom"]['need_approval'])
			&& $room["AnnouncementRoom"]['need_approval']
		) {
			return true;
		}
		return false;
	}
}