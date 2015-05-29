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
		/* 'NetCommons.NetCommonsBlock', */
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit')
			),
		)
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token',
	);

/**
 * view method
 *
 * @return void
 */
	public function view() {
		$this->__initAnnouncement();

		if ($this->request->is('ajax')) {
			$this->renderJson();
		} else {
			if (! $this->viewVars['announcement']['key'] && ! $this->viewVars['contentEditable']) {
				$this->autoRender = false;
			}
		}
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		$this->__initAnnouncement(['comments']);

		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}

			$data = Hash::merge(
				$this->data, [
					'Announcement' => [
						'status' => $status,
						'is_auto_translated' => true,
						'is_first_auto_translation' => true,
						'translation_engine' => ''
					]
				]
			);
			if (isset($this->viewVars['announcement']['key'])) {
				$data['Announcement']['key'] = $this->viewVars['announcement']['key'];
			}
			unset($data['Announcement']['id']);

			$announcement = $this->Announcement->saveAnnouncement($data);
			if (! $this->handleValidationError($this->Announcement->validationErrors)) {
				$results = $this->camelizeKeyRecursive($this->Announcement->data);
				$this->set([
					'announcement' => $results['announcement'],
				]);
				return;
			}
			$this->set('blockId', $announcement['Announcement']['block_id']);
			$this->redirectByFrameId();
			return;
		}
	}

/**
 * Initialize announcement related data
 *
 * @param array $contains Optional result sets
 * @return void
 */
	private function __initAnnouncement($contains = []) {
		if (! $announcement = $this->Announcement->getAnnouncement(
			$this->viewVars['blockId'],
			$this->viewVars['roomId'],
			$this->viewVars['contentEditable']
		)) {
			$announcement = $this->Announcement->create(
				array(
					'id' => null,
					'key' => null,
					'block_id' => null,
					'status' => null
				)
			);

			$block = $this->Block->create([
				'id' => $this->viewVars['blockId'],
				'key' => $this->viewVars['blockKey'],
			]);

			$announcement['Block'] = $block['Block'];
		}
		$results = array(
			'contentStatus' => $announcement['Announcement']['status'],
		);

		if (in_array('comments', $contains, true)) {
			$results['comments'] = $this->Comment->getComments(
				array(
					'plugin_key' => $this->params['plugin'],
					'content_key' => isset($announcement['Announcement']['key']) ? $announcement['Announcement']['key'] : null,
				)
			);
		}

		$results = Hash::merge($announcement, $results);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}
}
