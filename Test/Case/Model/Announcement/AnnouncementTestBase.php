<?php
/**
 * Announcementテストの共通クラス
 *
 * @property Announcement $Announcement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementModelTestBase', 'Announcements.Test/Case/Model');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * Announcementテストの共通クラス
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementTestBase extends AnnouncementModelTestBase {

/**
 * data
 *
 * @var array
 */
	public $data = array(
		'Frame' => array(
			'id' => '6'
		),
		'Block' => array(
			'id' => '2',
			'language_id' => '2',
			'room_id' => '1',
			'key' => 'block_1',
			'plugin_key' => 'announcements',
		),
		'Announcement' => array(
			//'id' => '2',
			'language_id' => '2',
			'block_id' => '2',
			'key' => 'announcement_1',
			'status' => WorkflowComponent::STATUS_PUBLISHED,
			'content' => 'Announcement test'
		),
		'WorkflowComment' => array(
			'comment' => 'WorkflowComment test'
		),
	);

}
