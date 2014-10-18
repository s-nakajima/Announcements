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
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock', //use Announcement model
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
	);

/**
 * beforeFilter
 *
 * @return void
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		$frameId = (isset($this->params['pass'][0]) ? (int)$this->params['pass'][0] : 0);
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException();
		}
		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException();
		}
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0) {
		return $this->view($frameId);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0) {
		//Announcementデータを取得
		$announcement = $this->Announcement->getAnnouncement(
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);

		if (! $announcement) {
			$announcement = $this->Announcement->create();
			$announcement['Announcement']['content'] = '';
		}

		//Announcementデータをviewにセット
		$this->set('announcement', $announcement);

		return $this->render('Announcements/view');
	}

/**
 * show manage method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 * @throws ForbiddenException
 */
	public function manage($frameId = 0) {
		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			throw new ForbiddenException();
		}

		return $this->render('Announcements/manage', false);
	}
}
