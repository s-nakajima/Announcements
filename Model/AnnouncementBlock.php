<?php
/**
 * AnnouncementBlock Model
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * Announcement Model
 */
class AnnouncementBlock extends AnnouncementsAppModel {

/**
 * hasMany
 *
 * @var array
 */
	public $hasMany = array(
		'AnnouncementBlocksPart' => array(
			'className' => 'Announcements.AnnouncementBlocksPart',
			'order' => 'AnnouncementBlocksPart.part_id ASC',
			'dependent' => true,
		)
	);

/**
 * Validation rules
 *
 * @var array
 */
	/*public $validate = array(
		'announcement_block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'required' => true,
				'allowEmpty' => false,
				// 'message' => 'The input must be a number.'
			)
		),
		'need_approval_mail' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'last' => true,
				'required' => true,
				// 'message' => 'The input must be a boolean.'
			)
		),
	);*/

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
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'required' => true,
					'allowEmpty' => false,
					'message' => __('The input must be a number.')
				)
			),
			'send_mail' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'last' => true,
					'required' => true,
					'message' => __('The input must be a boolean.')
				)
			),
			// mail_subject
			// mail_body
		);
	}

/**
 * 初期データ取得
 *
 * @param integer $blockId
 * @return array
 * @access public
 */
	public function findByBlockIdOrDefault($blockId) {
		$data = $this->findByBlockId($blockId);
		if (empty($data[$this->alias])) {
			$data = $this->create();
			$data[$this->alias]['block_id'] = $blockId;
			$AnnouncementBlocksPart = ClassRegistry::init('Announcements.AnnouncementBlocksPart');
			$data = array_merge($data, $AnnouncementBlocksPart->findByAnnouncementBlockIdOrDefault(0));
		}
		return $data;
	}
}
