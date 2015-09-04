<?php
/**
 * Announcements Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsAppController', 'Announcements.Controller');

/**
 * Announcements Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Controller
 */
class AnnouncementsController extends AnnouncementsAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Blocks.Block',
		'Comments.Comment',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit')
			),
		)
	);

/**
 * view method
 *
 * @return void
 */
	public function view() {
		$announcement = $this->Announcement->getAnnouncement();
		if (! $announcement) {
			if (CurrentUtility::permission('content_editable')) {
				$announcement = $this->Announcement->createAnnouncement();
			} else {
				$this->autoRender = false;
			}
		}
		if ($announcement) {
			$this->set('announcement', $announcement['Announcement']);
		}
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		if ($this->request->isPost() || $this->request->isPut()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}

			$data = $this->data;
			$data['Announcement']['status'] = $status;
			unset($data['Announcement']['id']);

			if ($announcement = $this->Announcement->saveAnnouncement($data)) {
				$this->set('blockId', $announcement['Announcement']['block_id']);
				$this->redirectByFrameId();
				return;
			}
			$this->handleValidationError($this->Announcement->validationErrors);

		} else {
			//初期データセット
			if (! $this->request->data = $this->Announcement->getAnnouncement()) {
				$this->request->data = $this->Announcement->createAnnouncement();
			}
			$this->request->data['Frame'] = array(
				'id' => $this->viewVars['frameId'],
				'key' => $this->viewVars['frameKey']
			);
		}

		$comments = $this->Announcement->getCommentsByContentKey($this->request->data['Announcement']['key']);
		$this->set('comments', $comments);
	}
}
