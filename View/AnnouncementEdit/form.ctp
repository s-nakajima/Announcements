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

echo $this->Form->create('Announcement' . (int)$frameId, array(
			'default' => false,
			'inputDefaults' => array('label' => false, 'div' => false),
		));

echo $this->Form->input('Announcement.content', array(
			'type' => 'textarea',
			'value' => '',
		)
	);

echo $this->Form->input('Comment.comment', array(
			'type' => 'textarea',
			'value' => '',
		)
	);

echo $this->Form->input('Comment.plugin_key', array(
			'type' => 'hidden',
			'value' => 'announcements',
			'ng-model' => 'edit.data.Comment.plugin_key',
		)
	);

echo $this->Form->input('Comment.content_key', array(
			'type' => 'hidden',
			'value' => $announcement['Announcement']['key'],
			'ng-model' => 'edit.data.Comment.content_key',
		)
	);

echo $this->Form->input('Announcement.block_id', array(
			'type' => 'hidden',
			'value' => (int)$blockId,
			'ng-model' => 'edit.data.Announcement.block_id',
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

echo $this->element('AnnouncementEdit/common_form');

echo $this->Form->end();
