<?php
/**
 * Announcement Model
 *
 * @property Block $Block
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * Announcement Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Model
 */
class Announcement extends AnnouncementsAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Invalid request.',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Invalid request.',
				//'allowEmpty' => false,
				//'required' => false,
				'last' => true, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Invalid request.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'range' => array(
				'rule' => array('range', 0, 5),
				'message' => 'Invalid request.',
			),
		),
		'is_auto_translated' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'Invalid request.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * get content data
 *
 * @param int $blockId blocks.id
 * @param boolean $contentEditable true can edit the content, false not can edit the content.
 * @return array
 */
	public function getAnnouncement($blockId, $contentEditable) {
		$conditions = array(
			'block_id' => $blockId,
		);
		if (! $contentEditable) {
			$conditions['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
		}

		return $this->find('first', array(
				'conditions' => $conditions,
				'order' => 'Announcement' . '.id DESC',
			)
		);
	}

/**
 * save announcement
 *
 * @param array $data received post data
 * @return mixed array Notepad, false error
 */
	public function saveAnnouncement($data) {
		$models = array(
			'Frame' => 'Frames.Frame',
			'Block' => 'Blocks.Block',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
			$this->$model->setDataSource('master');
		}

		//frame関連のセット
		$frame = $this->Frame->findById($data['Announcement']['frame_id']);
		if (! $frame) {
			return false;
		}
		$blockId = (isset($frame['Block']['id']) ? (int)$frame['Block']['id'] : 0);

		//DBへの登録
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			if (! $blockId) {
				//blocksテーブル登録
				$block = array();
				$block['Block']['room_id'] = $frame['Frame']['room_id'];
				$block['Block']['language_id'] = $frame['Frame']['language_id'];
				$block = $this->Block->save($block);
				$blockId = (int)$block['Block']['id'];

				//framesテーブル更新
				$frame['Frame']['block_id'] = $blockId;
				$this->Frame->save($frame);
			}

			//announcementsテーブル登録
			$announcement['Announcement'] = $data['Announcement'];
			$announcement['Announcement']['block_id'] = $blockId;
			$announcement['Announcement']['created_user'] = CakeSession::read('Auth.User.id');

			//保存結果を返す
			$this->save($announcement);
			$dataSource->commit();
			return true;

		} catch (Exception $ex) {
			CakeLog::error($ex->getTraceAsString());
			$dataSource->rollback();
			return false;
		}
	}
}
