<?php
/**
 * AnnouncementFrame Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

class AnnouncementFrame extends AppModel {

/**
 * テーブルの指定
 *
 * @var bool
 */
	public $useTable = 'frames';

/**
 * name
 *
 * @var string
 */
	public $name = "AnnouncementsFrame";

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
 * BlockIdが設定されているかどうか確認する。
 *
 * @param int $frameId frames.id
 * @return int blocks.id
 */
	public function getBlockId($frameId) {
		$frame = $this->findById($frameId);
		if ($frame
			&& isset($frame['AnnouncementFrame'])
			&& isset($frame['AnnouncementFrame']['block_id'])
			&& $frame['AnnouncementFrame']['block_id']) {
			return $frame['AnnouncementFrame']['block_id'];
		}
		return null;
	}
}