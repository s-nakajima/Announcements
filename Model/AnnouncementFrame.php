<?php
/**
 * Created by IntelliJ IDEA.
 * User: neko
 * Date: 2014/06/06
 * Time: 16:58
 * frame
 * frameとblockはhasOne
 * これは、お知らせ機能特有
 */

App::uses('AppModel', 'Model');

class AnnouncementFrame extends AppModel {
/**
 * テーブルの指定
 * @var bool
 */
	public $useTable = 'frames';

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


	//blockが存在するかどうかチェック？

/**
 * BlockIdが設定されているかどうか確認する。
 * @param $frameId
 * @return mixed
 */
	function getBlockId($frameId) {
		$frame = $this->findById($frameId);
		if($frame
			&& isset($frame['AnnouncementFrame'])
			&& isset($frame['AnnouncementFrame']['block_id'])
			&& $frame['AnnouncementFrame']['block_id']) {
			return $frame['AnnouncementFrame']['block_id'];
		}
	}


}