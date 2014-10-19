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

echo $this->Form->create(null);

echo $this->Form->input('Announcement.content', array(
			'type' => 'textarea',
			'value' => '',
		)
	);

echo $this->Form->input('Frame.frame_id', array(
			'type' => 'hidden',
			'value' => (int)$frameId,
		)
	);

echo $this->Form->input('Announcement.block_id', array(
			'type' => 'hidden',
			'value' => (int)$blockId,
		)
	);

if ($contentPublishable) {
	$options = array(
		NetCommonsBlockComponent::STATUS_PUBLISHED,
		NetCommonsBlockComponent::STATUS_DRAFTED,
		NetCommonsBlockComponent::STATUS_DISAPPROVED,
	);
} else {
	$options = array(
		NetCommonsBlockComponent::STATUS_APPROVED,
		NetCommonsBlockComponent::STATUS_DRAFTED,
	);
}
echo $this->Form->input('Announcement.status', array(
			'type' => 'select',
			'options' => array_combine($options, $options)
		)
	);

if (isset($announcement['Announcement']['key'])) {
	echo $this->Form->input('Announcement.key', array(
				'type' => 'hidden',
				'value' => $announcement['Announcement']['key'],
			)
		);
}
if (isset($announcement['Announcement']['id']) &&
		$announcement['Announcement']['status'] === NetCommonsBlockComponent::STATUS_DRAFTED) {

	echo $this->Form->input('Announcement.id', array(
				'type' => 'hidden',
				'value' => (int)$announcement['Announcement']['id'],
			)
		);
}

echo $this->Form->end();
