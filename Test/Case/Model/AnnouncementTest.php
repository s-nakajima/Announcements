<?php
/**
 * Announcement Model Test Case
 *
 * @property Announcement $Announcement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementAppModelTest', 'Announcements.Test/Case/Model');

/**
 *Announcement Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model
 */
class AnnouncementTest extends AnnouncementAppModelTest {

/**
 * testGetAnnouncement method
 *
 * @return void
 */
	public function testGetAnnouncement() {
		$blockId = 1;
		$contentEditable = true;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$expected = array(
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
				'is_auto_translated' => true,
				'translation_engine' => 'Lorem ipsum dolor sit amet',
				'comment' => null,
			),
			'Block' => array(
				'id' => '1',
				'language_id' => '2',
				'room_id' => '1',
				'key' => 'block_1',
				'name' => '',
			)
		);

		$this->_assertGetAnnouncement($expected, $result);
	}

/**
 * testGetAnnouncementByNoEditable method
 *
 * @return void
 */
	public function testGetAnnouncementByNoEditable() {
		$blockId = 1;
		$contentEditable = false;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$expected = array(
			'Announcement' => array(
				'id' => '1',
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. '	.
							'Convallis morbi fringilla gravida, '	.
							'phasellus feugiat dapibus velit nunc, '	.
							'pulvinar eget sollicitudin venenatis cum nullam, ' .
							'vivamus ut a sed, mollitia lectus. '	.
							'Nulla vestibulum massa neque ut et, id hendrerit sit, ' .
							'feugiat in taciti enim proin nibh, '	.
							'tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
				'is_auto_translated' => true,
				'translation_engine' => 'Lorem ipsum dolor sit amet',
				'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. '	.
							'Convallis morbi fringilla gravida, '	.
							'phasellus feugiat dapibus velit nunc, '	.
							'pulvinar eget sollicitudin venenatis cum nullam, ' .
							'vivamus ut a sed, mollitia lectus. '	.
							'Nulla vestibulum massa neque ut et, id hendrerit sit, ' .
							'feugiat in taciti enim proin nibh, '	.
							'tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			),
			'Block' => array(
				'id' => '1',
				'language_id' => '2',
				'room_id' => '1',
				'key' => 'block_1',
				'name' => '',
			)
		);

		$this->_assertGetAnnouncement($expected, $result);
	}

/**
 * testGetAnnouncementByNoBlockId method
 *
 * @return void
 */
	public function testGetAnnouncementByNoBlockId() {
		$blockId = 0;
		$contentEditable = true;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$expected = array(
			'Announcement' => array(
				'block_id' => '0',
				'key' => '',
				'status' => '0',
				'content' => '',
				'is_auto_translated' => '0',
				'key' => '',
				'id' => '0'
			),
		);

		$this->_assertGetAnnouncement($expected, $result);
	}

/**
 * testSaveAnnouncement method
 *
 * @return void
 */
	public function testSaveAnnouncement() {
		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'edit content',
				'comment' => 'edit comment',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			),
			'Frame' => array(
				'id' => '1'
			)
		);
		$result = $this->Announcement->saveAnnouncement($postData);
		$this->assertArrayHasKey('Announcement', $result, 'Error saveAnnouncement');

		$blockId = 1;
		$contentEditable = true;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$expected = array(
			'Announcement' => array(
				'id' => '21',
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '1',
				'content' => 'edit content',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
				'comment' => 'edit comment',
			),
			'Block' => array(
				'id' => '1',
				'language_id' => '2',
				'room_id' => '1',
				'key' => 'block_1',
				'name' => '',
			)
		);

		$this->_assertGetAnnouncement($expected, $result);
	}

/**
 * testSaveAnnouncementByNoBlockId method
 *
 * @return void
 */
	public function testSaveAnnouncementByNoBlockId() {
		$postData = array(
			'Announcement' => array(
				'status' => '1',
				'content' => 'add content',
				'is_auto_translated' => true,
				'translation_engine' => 'add translation_engine',
				'comment' => 'add comment',
			),
			'Frame' => array(
				'id' => '3'
			)
		);
		$result = $this->Announcement->saveAnnouncement($postData);
		$this->assertArrayHasKey('Announcement', $result, 'Error saveAnnouncement');

		$blockId = 3;
		$contentEditable = true;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$this->assertArrayHasKey('key', $result['Announcement'], 'Error ArrayHasKey Announcement.key');
		$this->assertTrue(strlen($result['Announcement']['key']) > 0, 'Error strlen Announcement.key');
		unset($result['Announcement']['key']);

		$this->assertArrayHasKey('key', $result['Block'], 'Error ArrayHasKey Block.key');
		$this->assertTrue(strlen($result['Block']['key']) > 0, 'Error strlen Block.key');
		unset($result['Block']['key']);

		$expected = array(
			'Announcement' => array(
				'id' => '21',
				'block_id' => '3',
				'status' => '1',
				'content' => 'add content',
				'is_auto_translated' => true,
				'translation_engine' => 'add translation_engine',
				'comment' => 'add comment',
			),
			'Block' => array(
				'id' => '3',
				'language_id' => '2',
				'room_id' => '1',
				'name' => '',
			)
		);

		$this->_assertGetAnnouncement($expected, $result);
	}

/**
 * testSaveAnnouncementByStatusDisapproved method
 *
 * @return void
 */
	public function testSaveAnnouncementByStatusDisapproved() {
		$postData = array(
			'Announcement' => array(
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => '4',
				'content' => 'edit content',
				'comment' => 'edit comment',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			),
			'Frame' => array(
				'id' => '1'
			)
		);
		$result = $this->Announcement->saveAnnouncement($postData);
		$this->assertArrayHasKey('Announcement', $result, 'Error saveAnnouncement');

		$blockId = 1;
		$contentEditable = true;
		$result = $this->Announcement->getAnnouncement($blockId, $contentEditable);

		$expected = array(
			'Announcement' => array(
				'id' => '21',
				'block_id' => '1',
				'key' => 'announcement_1',
				'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
				'content' => 'edit content',
				'comment' => 'edit comment',
				'is_auto_translated' => true,
				'translation_engine' => 'edit translation_engine',
			),
			'Block' => array(
				'id' => '1',
				'language_id' => '2',
				'room_id' => '1',
				'key' => 'block_1',
				'name' => '',
			)
		);

		$this->_assertGetAnnouncement($expected, $result);
	}

}
