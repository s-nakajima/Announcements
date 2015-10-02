<?php
/**
 * WorkflowCommentFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowCommentFixture', 'Workflow.Test/Fixture');

/**
 * WorkflowCommentFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcement\Test\Fixture
 * @codeCoverageIgnore
 */
class WorkflowComment4announcementsFixture extends WorkflowCommentFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'WorkflowComment';

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		parent::init();

		$records = array_keys($this->records);
		foreach ($records as $i) {
			if ($this->records[$i]['content_key'] === 'comment_content_1') {
				$this->records[$i]['content_key'] = 'announcement_1';
			} elseif ($this->records[$i]['content_key'] === 'comment_content_2') {
				$this->records[$i]['content_key'] = 'announcement_2';
			}
		}
	}

}
