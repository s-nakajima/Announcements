<?php
/**
 * AnnouncementEditController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementEditController', 'Announcements.Controller');
App::uses('AnnouncementsAppControllerTest', 'Announcements.Test/Case/Controller');

/**
 * AnnouncementEditController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementEditControllerTest extends AnnouncementsAppControllerTest {

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginAdmin();

		$this->testAction('/announcements/announcement_edit/index/1.json', array('method' => 'get'));

		$this->assertTextContains('<textarea', $this->view);
		$this->assertTextContains('ui-tinymce="tinymceOptions"', $this->view);
		$this->assertTextContains('ng-model="edit.data.Announcement.content"', $this->view);

		$this->assertTextContains('ng-click="cancel()"', $this->view);
		$this->assertTextContains('ng-click="save(\'3\')"', $this->view);
		$this->assertTextContains('ng-click="save(\'1\')"', $this->view);

		$this->_logout();
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginAdmin();

		$this->testAction('/announcements/announcement_edit/view/1.json', array('method' => 'get'));

		$this->assertTextContains('<textarea', $this->view);
		$this->assertTextContains('ui-tinymce="tinymceOptions"', $this->view);
		$this->assertTextContains('ng-model="edit.data.Announcement.content"', $this->view);
		$this->assertTextContains('ng-model="edit.data.Announcement.comment"', $this->view);

		$this->assertTextContains('ng-click="cancel()"', $this->view);
		$this->assertTextContains('ng-click="save(\'3\')"', $this->view);
		$this->assertTextContains('ng-click="save(\'1\')"', $this->view);

		$this->_logout();
	}

/**
 * testView method
 *
 * @return void
 */
	public function testViewLatest() {
		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginAdmin();

		$this->testAction('/announcements/announcement_edit/view_latest/1.json', array('method' => 'get'));

		$expected = array(
			'announcement' => array(
				'Announcement' => array(
					'id' => '2',
					'block_id' => '1',
					'key' => 'announcement_1',
					'status' => '3',
					'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. '	.
								'Convallis morbi fringilla gravida, '	.
								'phasellus feugiat dapibus velit nunc, '	.
								'pulvinar eget sollicitudin venenatis cum nullam, ' .
								'vivamus ut a sed, mollitia lectus. '	.
								'Nulla vestibulum massa neque ut et, id hendrerit sit, ' .
								'feugiat in taciti enim proin nibh, '	.
								'tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'comment' => null,
					'is_auto_translated' => true,
					'translation_engine' => 'Lorem ipsum dolor sit amet',
					'created_user' => '1',
					'modified_user' => '1',
				),
				'Block' => array(
					'id' => '1',
					'language_id' => '2',
					'room_id' => '1',
					'key' => 'block_1',
					'name' => '',
					'created_user' => '1',
					'modified_user' => '1',
				),
				'CreatedUser' => array(
					'key' => 'nickname',
					'value' => 'admin'
				),
			),
			'comments' => array(
				'current' => 1,
				'hasPrev' => false,
				'hasNext' => false,
				'data' => array(
					0 => array(
						'Announcement' => array(
							'id' => '1',
							'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. '	.
										'Convallis morbi fringilla gravida, '	.
										'phasellus feugiat dapibus velit nunc, '	.
										'pulvinar eget sollicitudin venenatis cum nullam, ' .
										'vivamus ut a sed, mollitia lectus. '	.
										'Nulla vestibulum massa neque ut et, id hendrerit sit, ' .
										'feugiat in taciti enim proin nibh, '	.
										'tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
							'created_user' => '1',
							'created' => 'CURRENT_DATETIME',
						),
						'CreatedUser' => array(
							'key' => 'nickname',
							'value' => 'admin'
						),
					),
				),
			),
		);

		$result = json_decode($this->view, true);
		unset(
			$result['announcement']['Announcement']['created'],
			$result['announcement']['Announcement']['modified'],
			$result['announcement']['Block']['created'],
			$result['announcement']['Block']['modified']
		);
		$keys = array_keys($result['comments']['data']);
		foreach ($keys as $i) {
			if (isset($result['comments']['data'][$i]['Announcement']['created'])) {
				$result['comments']['data'][$i]['Announcement']['created'] = 'CURRENT_DATETIME';
			}
		}

		$this->assertEquals($expected, $result, 'Json data =' . print_r($result, true));

		$this->_logout();
	}

/**
 * testCommentsLastPage method
 *
 * @return void
 */
	public function testComments() {
		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginAdmin();

		$this->testAction('/announcements/announcement_edit/comment/2.json', array('method' => 'get'));

		$expected = array(
			'comments' => array(
				'current' => 1,
				'hasPrev' => false,
				'hasNext' => true,
				'data' => array(
					0 => array(
						'Announcement' => array(
							'id' => '20', 'comment' => 'Comment 20',
							'created_user' => '1', 'created' => 'CURRENT_DATETIME',
						),
						'CreatedUser' => array(
							'key' => 'nickname', 'value' => 'admin'
						),
					),
					1 => array(
						'Announcement' => array(
							'id' => '19', 'comment' => 'Comment 19',
							'created_user' => '1', 'created' => 'CURRENT_DATETIME',
						),
						'CreatedUser' => array(
							'key' => 'nickname', 'value' => 'admin'
						),
					),
					2 => array(
						'Announcement' => array(
							'id' => '18', 'comment' => 'Comment 18',
							'created_user' => '1', 'created' => 'CURRENT_DATETIME',
						),
						'CreatedUser' => array(
							'key' => 'nickname', 'value' => 'admin'
						),
					),
					3 => array(
						'Announcement' => array(
							'id' => '17', 'comment' => 'Comment 17',
							'created_user' => '1', 'created' => 'CURRENT_DATETIME',
						),
						'CreatedUser' => array(
							'key' => 'nickname', 'value' => 'admin'
						),
					),
					4 => array(
						'Announcement' => array(
							'id' => '16', 'comment' => 'Comment 16',
							'created_user' => '1', 'created' => 'CURRENT_DATETIME',
						),
						'CreatedUser' => array(
							'key' => 'nickname', 'value' => 'admin'
						),
					),
				),
			),
		);

		$result = json_decode($this->view, true);
		$keys = array_keys($result['comments']['data']);
		foreach ($keys as $i) {
			if (isset($result['comments']['data'][$i]['Announcement']['created'])) {
				$result['comments']['data'][$i]['Announcement']['created'] = 'CURRENT_DATETIME';
			}
		}

		$this->assertEquals($expected, $result, 'Json data =' . print_r($result, true));

		$this->_logout();
	}

/**
 * testForm method
 *
 * @return void
 */
	public function testForm() {
		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginAdmin();

		$this->testAction('/announcements/announcement_edit/form/1.json', array('method' => 'get'));
		$this->view = trim(str_replace(array("\r\n", "\r", "\n"), '', $this->view));

		$expected = '<form action="/var/www/app/lib/Cake/Console/announcements/announcement_edit/form/1.json" ' .
							'id="Announcement1FormForm" onsubmit="event.returnValue = false; return false;" ' .
							'method="post" accept-charset="utf-8">' .
						'<div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>' .
						'<textarea name="data[Announcement][content]" cols="30" rows="6" id="AnnouncementContent"></textarea>' .
						'<textarea name="data[Announcement][comment]" cols="30" rows="6" id="AnnouncementComment"></textarea>' .
						'<select name="data[Announcement][status]" id="AnnouncementStatus">' .
						'<option value="1">1</option>' .
						'<option value="3">3</option>' .
						'<option value="4">4</option>' .
						'</select>' .
						'<input type="hidden" name="data[Frame][id]" value="1" ng-model="edit.data.Frame.id" id="FrameId"/>' .
						'<input type="hidden" name="data[Announcement][block_id]" value="1" ng-model="edit.data.Announcement.block_id" id="AnnouncementBlockId"/>' .
						'<input type="hidden" name="data[Announcement][key]" value="announcement_1" ng-model="edit.data.Announcement.key" id="AnnouncementKey"/>' .
						'<input type="hidden" name="data[Announcement][id]" value="2" ng-model="edit.data.Announcement.id" id="AnnouncementId"/>' .
					'</form>';

		$this->assertTextContains($expected, $this->view);

		$this->_logout();
	}

/**
 * testFormEditor method
 *
 * @return void
 */
	public function testFormByEditor() {
		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginEditor();

		$this->testAction('/announcements/announcement_edit/form/1.json', array('method' => 'get'));
		$this->view = trim(str_replace(array("\r\n", "\r", "\n"), '', $this->view));

		$expected = '<form action="/var/www/app/lib/Cake/Console/announcements/announcement_edit/form/1.json" ' .
							'id="Announcement1FormForm" onsubmit="event.returnValue = false; return false;" ' .
							'method="post" accept-charset="utf-8">' .
						'<div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>' .
						'<textarea name="data[Announcement][content]" cols="30" rows="6" id="AnnouncementContent"></textarea>' .
						'<textarea name="data[Announcement][comment]" cols="30" rows="6" id="AnnouncementComment"></textarea>' .
						'<select name="data[Announcement][status]" id="AnnouncementStatus">' .
						'<option value="2">2</option>' .
						'<option value="3">3</option>' .
						'</select>' .
						'<input type="hidden" name="data[Frame][id]" value="1" ng-model="edit.data.Frame.id" id="FrameId"/>' .
						'<input type="hidden" name="data[Announcement][block_id]" value="1" ng-model="edit.data.Announcement.block_id" id="AnnouncementBlockId"/>' .
						'<input type="hidden" name="data[Announcement][key]" value="announcement_1" ng-model="edit.data.Announcement.key" id="AnnouncementKey"/>' .
						'<input type="hidden" name="data[Announcement][id]" value="2" ng-model="edit.data.Announcement.id" id="AnnouncementId"/>' .
					'</form>';

		$this->assertTextContains($expected, $this->view);

		$this->_logout();
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
		$this->_generateController('Announcements.AnnouncementEdit');
		$this->_loginAdmin();

		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'edit content',
				'comment' => 'edit comment',
			),
			'Frame' => array(
				'id' => '1'
			)
		);

		$expected = array(
			'name' => __d('net_commons', 'Successfully finished.'),
			'announcement' => array(
				'Announcement' => array(
					'id' => '21',
					'block_id' => '1',
					'key' => 'announcement_1',
					'status' => '1',
					'content' => 'edit content',
					'comment' => 'edit comment',
					'is_auto_translated' => false,
					'translation_engine' => null,
					'created_user' => '1',
					'modified_user' => '0',
				),
				'Block' => array(
					'id' => '1',
					'language_id' => '2',
					'room_id' => '1',
					'key' => 'block_1',
					'name' => '',
					'created_user' => '1',
					'modified_user' => '1',
				),
				'CreatedUser' => array(
					'key' => 'nickname',
					'value' => 'admin'
				),
			)
		);

		$this->testAction('/announcements/announcement_edit/edit/1.json',
			array(
				'method' => 'post',
				'data' => $postData
			)
		);
		unset(
			$this->vars['result']['announcement']['Announcement']['created'],
			$this->vars['result']['announcement']['Announcement']['modified'],
			$this->vars['result']['announcement']['Block']['created'],
			$this->vars['result']['announcement']['Block']['modified']
		);

		$this->assertEquals($expected, $this->vars['result'],
				'Json data =' . print_r($this->vars['result'], true));

		$this->_logout();
	}

}
