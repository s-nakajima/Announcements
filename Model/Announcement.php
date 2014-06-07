<?php
/**
 * Announcement Model
 *
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 *
 * Data.status_id
 * 1. 公開中
 * 2. 下書き中
 * 3. 公開申請中
 */

App::uses('AppModel', 'Model');

/**
 * Summary for Announcement Model
 */
class Announcement extends AppModel {



	public  $hasMany = 'AnnouncementDatum';


	public function getData($blockId , $lang,  $isSetting=null) {

		//if($isSetting){
			//公開情報の最新を返す
			return $this->getPublishData($blockId ,$lang);
		//}
		;
	}

	public function getPublishData($blockId , $lang) {
		$this->hasMany['AnnouncementDatum']["conditions"] = array(
			//'AnnouncementDatum.status_id'=>1,
			//'AnnouncementDatum.language_id'=>$lang
		);
		$this->hasMany['AnnouncementDatum']['order'] = array(
			//'AnnouncementDatum.id DESC'
		);
		return $this->find('all');;




	}
}
