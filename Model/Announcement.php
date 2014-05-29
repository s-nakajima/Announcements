<?php
/**
 * Announcement Model
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * Announcement Model
 */
class Announcement extends AnnouncementsAppModel {

/**
 * hasOne
 *
 * @var array
 */
	public $hasOne = array(
		'AnnouncementRevision' => array(
			'className' => 'Announcements.AnnouncementRevision'
		)
	);

/**
 * Behavior
 *
 * @var array
 */
	public $actsAs = array(
		'Revision.Revision' => array(
			'modelName' => 'Announcements.AnnouncementRevision',
			'fields' => array('content')
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
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'required' => true,
					'allowEmpty' => false,
					'message' => __('The input must be a number.')
				)
			),
			'is_published' => array(
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
 * リクエストデータに既存IDマージ処理
 *
 * @param  array $requestData
 * @param  array $announcement
 * @return array
 * @access public
 */
	public function mergeRequestId($requestData, $announcement) {
		$requestData[$this->alias]['id'] = !empty($announcement[$this->alias]['id']) ? $announcement[$this->alias]['id'] : 0;
		$requestData[$this->alias]['block_id'] = !empty($announcement[$this->alias]['block_id']) ? $announcement[$this->alias]['block_id'] : 0;
		$requestData['AnnouncementRevision']['id'] = !empty($announcement['AnnouncementRevision']['id']) ? $announcement['AnnouncementRevision']['id'] : 0;
		return $requestData;
	}

}
