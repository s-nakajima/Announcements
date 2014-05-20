<?php
/**
 * AnnouncementBlocksPart Model
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * AnnouncementBlocksPart Model
 */
class AnnouncementBlocksPart extends AnnouncementsAppModel {

/**
 * 初期値
 *
 * @var array
 */
	public $records = array(
		array(
			'announcement_block_id' => 0,
			'part_id' => 1,			// TODO: 1固定にしている
			'can_create_content' => true,
			'can_publish_content' => true,
			'can_send_mail' => true,
		),
		array(
			'announcement_block_id' => 0,
			'part_id' => 2,			// TODO: 2固定にしている
			'can_create_content' => false,
			'can_publish_content' => false,
			'can_send_mail' => true,
		),
		array(
			'announcement_block_id' => 0,
			'part_id' => 3,			// TODO: 3固定にしている
			'can_create_content' => false,
			'can_publish_content' => false,
			'can_send_mail' => false,
		),
		array(
			'announcement_block_id' => 0,
			'part_id' => 4,			// TODO: 4固定にしている
			'can_create_content' => false,
			'can_publish_content' => false,
			'can_send_mail' => false,
		),
	);

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
			'can_create_content' => array(
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
 * 初期データを取得する。
 *
 * @param integer $announcementBlockId
 * @return array
 * @access private
 */
	private function __generateArray($announcementBlockId) {
		$initData = $this->create();
		$data[$this->alias] = $this->records;
		foreach ($data[$this->alias] as $key => $buf) {
			$data[$this->alias][$key]['announcement_block_id'] = $announcementBlockId;
			$data[$this->alias][$key] = array_merge($initData[$this->alias], $data[$this->alias][$key]);
		}

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
