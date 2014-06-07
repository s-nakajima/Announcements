<?php
/**
 * AnnouncementDatum Model
 *
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for AnnouncementDatum Model
 */
class AnnouncementDatum extends AppModel {

	public $name = 'AnnouncementDatum';

	public $useTable = 'announcement_data';

	public $belongsTo = 'Announcement';

	public $isPublish = 1;

	public function getData($blockId , $lang,  $isSetting=null) {
		if(! $isSetting) {
			$this->getPublishData($blockId , $lang);
		}
		return $this->find('first' , array(
			'conditions' => array(
				'Announcement.block_id'=>$blockId,
				'AnnouncementDatum.language_id'=>$lang,
			),
			'order'=>'AnnouncementDatum.id DESC',
		));
	}

	public function getPublishData($blockId , $lang) {
		return $this->find('first' , array(
			'conditions' => array(
				'Announcement.block_id'=>$blockId,
				'AnnouncementDatum.language_id'=>$lang,
				'AnnouncementDatum.status_id'=>$this->isPublish,
			),
			'order'=>'AnnouncementDatum.id DESC'
		));
	}
}
