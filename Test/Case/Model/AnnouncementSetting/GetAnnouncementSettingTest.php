<?php
/**
 * AnnouncementSetting::getAnnouncementSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * AnnouncementSetting::getAnnouncementSetting()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Announcements\Test\Case\Model\AnnouncementSetting
 */
class AnnouncementSettingGetAnnouncementSettingTest extends NetCommonsGetTest {

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
	protected $_methodName = 'getAnnouncementSetting';

/**
 * getAnnouncementSetting()のテスト
 *
 * @return void
 * @see AnnouncementSetting::getAnnouncementSetting()
 */
	public function testGetAnnouncementSetting() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		Current::write('Block.key', 'block_1');
		Current::write('Language.id', '2');
		//データ生成

		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		//debug($result);
		$this->assertArrayHasKey('use_workflow', $result[$this->$model->alias]);
	}

}
