<?php
/**
 * AnnouncementSetting::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('BlockFixture', 'Blocks.Test/Fixture');

/**
 * AnnouncementSetting::validate()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Announcements\Test\Case\Model\AnnouncementSetting
 */
class AnnouncementSettingValidateTest extends NetCommonsValidateTest {

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
	protected $_methodName = 'validates';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 * @see AnnouncementSetting::beforeValidate()
 * @see NetCommonsValidateTest::testValidationError()
 */
	public function dataProviderValidationError() {
		$data['AnnouncementSetting'] = (new BlockFixture())->records[0];
		$data['AnnouncementSetting']['use_workflow'] = '0';

		//debug($data);
		return array(
			array('data' => $data, 'field' => 'language_id', 'value' => 'xxx',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'room_id', 'value' => 'xxx',
				'message' => __d('net_commons', 'Invalid request.')),
			// BlockSettingの追加validate
			array('data' => $data, 'field' => 'use_workflow', 'value' => 'xxx',
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
