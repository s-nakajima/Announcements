<?php
/**
 * AnnouncementBlockSetting Model
 *
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for AnnouncementBlockSetting Model
 */
class AnnouncementBlockSetting extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'announcement_block_setting';

/**
 * validate
 *
 * @var array
 */
	public $validate = array(
		'block_id' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => ' It is required and must be a number.'
		)
	);

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
 * ブロックIDから設定を取得する
 *
 * @param int $blockId blocks.id
 * @return array
 */
	public function findByBlockId($blockId) {
		$rtn = $this->find('first', array(
			'conditions' => array(
				$this->name . '.block_id' => $blockId
			)
		));
		return $rtn;
	}

/**
 * ブロックIDからテーブルのIDを取得する
 *
 * @param int $blockId blocks.id
 * @return array
 */
	public function getIdByBlockId($blockId) {
		$block = $this->findByBlockId($blockId);
		if ( isset($block[$this->name])
			&& isset($block[$this->name]['id'])
			&& $block[$this->name]['id']
		) {
			return $block[$this->name]['id'];
		}
		return null;
	}
}
