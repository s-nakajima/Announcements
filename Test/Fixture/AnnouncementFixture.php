<?php
/**
 * AnnouncementFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * AnnouncementFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcement\Test\Fixture
 * @codeCoverageIgnore
 */
class AnnouncementFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'language_id' => '2',
			'block_id' => '2',
			'key' => 'announcement_1',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '0',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
			'created' => '2014-10-09 16:07:57',
			'modified_user' => '1',
			'modified' => '2014-10-09 16:07:57'
		),
		array(
			'id' => '2',
			'language_id' => '2',
			'block_id' => '2',
			'key' => 'announcement_1',
			'status' => '4',
			'is_active' => '0',
			'is_latest' => '1',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
			'created' => '2014-10-09 16:07:57',
			'modified_user' => '1',
			'modified' => '2014-10-09 16:07:57'
		),
		array(
			'id' => '3',
			'language_id' => '2',
			'block_id' => '4',
			'key' => 'announcement_2',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '1',
			'content' => 'Content 11',
			'created_user' => '1',
			'created' => '2014-10-09 16:07:57',
			'modified_user' => '1',
			'modified' => '2014-10-09 16:07:57'
		),
		array(
			'id' => '4',
			'language_id' => '2',
			'block_id' => '6',
			'key' => 'announcement_3',
			'status' => '2',
			'is_active' => '0',
			'is_latest' => '1',
			'content' => 'Content 12',
			'created_user' => '1',
			'created' => '2014-10-09 16:07:57',
			'modified_user' => '1',
			'modified' => '2014-10-09 16:07:57'
		),

		//101-200まで、ページ遷移のためのテスト

	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Announcements') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new AnnouncementsSchema())->tables['announcements'];
		parent::init();
	}

}
