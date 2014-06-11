<?php
/**
 * Announcement Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for Announcement Model
 */
class Announcement extends AppModel {

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
 * getByBlockId
 *
 * @param int $blockId blocks.id
 * @return null or int
 */
	public function getByBlockId($blockId) {
		$dd = $this->find(
			'first',
			array(
				'conditions' => array('Announcement.block_id' => $blockId)
			)
		);

		if (isset($dd['Announcement'])
			&& isset($dd['Announcement']['id'])
			&& $dd['Announcement']['id']
		) {
			return $dd['Announcement']['id'];
		}
		return null;
	}
}
