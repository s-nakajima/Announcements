<?php
/**
 * AnnouncementRevision Model
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * AnnouncementRevision Model
 */
class AnnouncementRevision extends AnnouncementsAppModel {

/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'HtmlPurifier.HtmlPurifier' => array(
			'config' => 'RichTextEditor',
			'fields' => array(
				'content'
			),
		),
	);

/**
 * construct
 *
 * @param boolean|integer|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @return  void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		Configure::load('Revision.config');
		$statusId = Configure::read('Revision.status_id');

		$this->validate = array(
			'announcement_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'required' => true,
					'allowEmpty' => false,
					'message' => __('The input must be a number.')
				)
			),
			'status_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'required' => true,
					'allowEmpty' => false,
					'message' => __('The input must be a number.')
				),
				'inList' => array(
					'rule' => array('inList', array(
						$statusId['draft'],
						$statusId['published'],
						$statusId['pending'],
						$statusId['rejected'],
						$statusId['auto_draft']
					), false),
					'allowEmpty' => false,
					'message' => __('It contains an invalid string.')
				)
			),
			'content' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'last' => true,
					'message' => __('Please be sure to input.')
				),
				// 'maxLength' => array(
				// 	'rule' => array('maxLength', NC_VALIDATOR_WYSIWYG_LEN),
				// 	'message' => __('The input must be up to %s characters.', NC_VALIDATOR_WYSIWYG_LEN),
				// )
			),
		);
	}
}
