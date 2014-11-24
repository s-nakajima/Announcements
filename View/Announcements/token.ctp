<?php
/**
 * announcements token template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$this->NetCommonsForm->create('Announcement' . (int)$frameId);

$this->NetCommonsForm->input('Announcement.content', array(
			'type' => 'textarea',
			'value' => '',
		)
	);

$this->NetCommonsForm->input('Comment.comment', array(
			'type' => 'textarea',
			'value' => '',
		)
	);

$this->NetCommonsForm->input('Comment.plugin_key', array(
			'type' => 'hidden',
			'value' => 'announcements',
		)
	);

$this->NetCommonsForm->input('Comment.content_key', array(
			'type' => 'hidden',
			'value' => $announcement['Announcement']['key'],
		)
	);

$this->NetCommonsForm->input('Announcement.block_id', array(
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
$this->NetCommonsForm->input('Announcement.status', array(
			'type' => 'select',
			'options' => array_combine($options, $options)
		)
	);

$this->NetCommonsForm->input('Frame.id', array(
			'type' => 'hidden',
			'value' => (int)$frameId,
		)
	);

$this->NetCommonsForm->input('Announcement.key', array(
			'type' => 'hidden',
			'value' => $announcement['Announcement']['key'],
		)
	);

$this->NetCommonsForm->input('Announcement.id', array(
			'type' => 'hidden',
			'value' => (int)$announcement['Announcement']['id'],
		)
	);

echo $this->NetCommonsForm->endJson();
