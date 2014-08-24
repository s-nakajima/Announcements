<?php
/**
 * AnnouncementsAppController
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AppController', 'Controller');

class AnnouncementsAppController extends AppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
		'Announcements.AnnouncementPartsSetting',
		'Announcements.AnnouncementSetting',
		'Announcements.RoomPart',
		'Frames.Frame',
		'LanguagesPart',
	);

/**
 * components
 * @var array
 */
	public $components = array(
		'Security',
	);

/**
 * langId
 *
 * @var int
 */
	public $langId = 2;

}
