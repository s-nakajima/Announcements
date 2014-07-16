<?php
/**
 * AnnouncementBlockMessage Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for AnnouncementBlockMessage Model
 */
class AnnouncementBlockMessage extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

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
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'announcement_block_message';

/**
 * ブロックIDから設定を取得する
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @return array
 */
	public function findByBlockId($blockId, $langId) {
		$rtn = $this->find('first', array(
			'conditions' => array(
				$this->name . '.block_id' => $blockId,
				$this->name . '.language_id' => $langId
			)
		));
		return $rtn;
	}

/**
 * ブロックIDからテーブルのIDを取得する
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @return array
 */
	public function getIdByBlockId($blockId, $langId) {
		$block = $this->findByBlockId($blockId, $langId);
		if ( isset($block[$this->name])
			&& isset($block[$this->name]['id'])
			&& $block[$this->name]['id']
		) {
			return $block[$this->name]['id'];
		}
		return null;
	}

}
