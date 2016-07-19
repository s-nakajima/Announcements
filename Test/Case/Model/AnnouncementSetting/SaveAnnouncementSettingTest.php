<?php
/**
 * AnnouncementSetting::saveAnnouncementSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('BlockFixture', 'Blocks.Test/Fixture');

/**
 * AnnouncementSetting::saveAnnouncementSetting()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Announcements\Test\Case\Model\AnnouncementSetting
 */
class AnnouncementSettingSaveAnnouncementSettingTest extends NetCommonsSaveTest {

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
	protected $_methodName = 'saveAnnouncementSetting';

/**
 * block key
 *
 * @var string
 */
	public $blockKey = 'abb04363f5d840d734a5779634c306a1';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Current::write('Plugin.key', $this->plugin);
		Current::write('Block.key', $this->blockKey);
	}

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$data['AnnouncementSetting'] = (new BlockFixture())->records[0];
		$data['AnnouncementSetting']['content_count'] = '0';
		$data['AnnouncementSetting']['use_workflow'] = '0';
		$data['AnnouncementSetting']['key'] = $this->blockKey;

		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.AnnouncementSetting.id', null);
		//$results[1] = Hash::insert($results[1], '0.AnnouncementSetting.key', null);
		$results[1] = Hash::remove($results[1], '0.AnnouncementSetting.created_user');

		return $results;
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Announcements.AnnouncementSetting', 'save'),
		);
	}

/**
 * SaveのValidationError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnValidationError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Announcements.AnnouncementSetting'),
		);
	}

}
