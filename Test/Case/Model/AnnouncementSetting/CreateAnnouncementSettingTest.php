<?php
/**
 * AnnouncementSetting::createAnnouncementSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * AnnouncementSetting::createAnnouncementSetting()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Announcements\Test\Case\Model\AnnouncementSetting
 */
class AnnouncementSettingCreateAnnouncementSettingTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.block_setting_for_announcement',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'announcements';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'AnnouncementSetting';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'createAnnouncementSetting';

/**
 * createAnnouncementSetting()のテスト
 *
 * @return void
 */
	public function testCreateAnnouncementSetting() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成

		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		//debug($result);
		$this->assertArrayHasKey('use_workflow', $result[$this->$model->alias]);
	}

}
