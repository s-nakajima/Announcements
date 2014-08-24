<?php
/**
 * AnnouncementNotification Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for AnnouncementBlockMessage Model
 */
class AnnouncementNotification extends AppModel {

/**
 * ブロックIDから設定を取得する
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @return array
 */
	public function get($blockId, $langId) {
		$rtn = $this->find('first', array(
			'conditions' => array(
				$this->name . '.block_id' => $blockId,
				$this->name . '.language_id' => $langId
			)
		));
		return $rtn;
	}

/**
 * get ID from the block ID
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @return array
 */
	public function getId($blockId, $langId) {
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
