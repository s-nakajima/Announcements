<?php
/**
 * announcements edit form view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->Form->input('Frame.id', array(
			'type' => 'hidden',
			'value' => (int)$frameId,
			'ng-model' => 'edit.data.Frame.id'
		)
	);

echo $this->Form->input('Announcement.block_id', array(
			'type' => 'hidden',
			'value' => (int)$blockId,
			'ng-model' => 'edit.data.Announcement.block_id',
		)
	);

echo $this->Form->input('Announcement.key', array(
			'type' => 'hidden',
			'value' => $announcement['Announcement']['key'],
			'ng-model' => 'edit.data.Announcement.key',
		)
	);

echo $this->Form->input('Announcement.id', array(
			'type' => 'hidden',
			'value' => (int)$announcement['Announcement']['id'],
			'ng-model' => 'edit.data.Announcement.id',
		)
	);
