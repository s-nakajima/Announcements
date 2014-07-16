<?php
/**
 * AnnouncementBlockPart Model
 *
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for AnnouncementBlockPart Model
 */
class AnnouncementBlockPart extends AppModel {

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
 * ブロックの設定を取得する (全パート）
 *
 * @param int $blockId blocks.id
 * @return array
 */
	public function getList($blockId) {
		$rtn = $this->find('all', array(
			'conditions' => array(
				$this->name . '.block_id' => $blockId
			)
		));
		return $rtn;
	}

/**
 * blockIdからidを取得する
 *
 * @param int $blockId blocks.id
 * @param int $partId parts.id
 * @return array
 */
	public function findByBlockId($blockId, $partId) {
		$rtn = $this->find('first', array(
			'conditions' => array(
				$this->name . '.block_id' => $blockId,
				$this->name . '.part_id' => $blockId
			)
		));
		return $rtn;
	}

/**
 * ブロックIDからidを取得する
 *
 * @param int $blockId blocks.id
 * @param int $partId parts.id
 * @return null
 */
	public function getIdByBlockId($blockId, $partId) {
		$block = $this->findByBlockId($blockId, $partId);
		if ($block
			&& isset($block[$this->name])
			&& isset($block[$this->name]['id'])
			&& $block[$this->name]['id']
		) {
			return $block[$this->name]['id'];
		}
		return null;
	}
}
