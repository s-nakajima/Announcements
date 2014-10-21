<?php
/**
 * announcements view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php //echo $this->Html->script('/announcements/js/announcements.js', array('inline' => false)); ?>

<?php if ($contentEditable) : ?>
	<div id="nc-announcements-<?php echo (int)$frameId; ?>"
		 ng-controller="Announcements"
		 ng-init="initialize(<?php echo (int)$frameId; ?>,
								<?php echo h(json_encode($announcement)); ?>)">

		<p class="text-right">
			<?php if ($contentPublishable &&
						$announcement['Announcement']['status'] === NetCommonsBlockComponent::STATUS_APPROVED) : ?>
				<button type="button" class="btn btn-danger"
						ng-disabled="sending"
						ng-controller="Announcements.publish"
						ng-hide="(announcement.Announcement.status !== '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>')"
						ng-click="save('<?php echo NetCommonsBlockComponent::STATUS_PUBLISHED ?>')">
					<?php echo __d('net_commons', 'Publish'); ?>
				</button>
			<?php endif; ?>

			<button class="btn btn-primary"
					tooltip="<?php echo __d('net_commons', 'Manage'); ?>"
					ng-click="showManage()">

				<span class="glyphicon glyphicon-cog"> </span>
			</button>
		</p>

		<div ng-bind-html="announcement.Announcement.content">
			<?php echo $announcement['Announcement']['content']; ?>
		</div>

		<p class="text-left">
			<?php echo $this->element('Announcements/status_label'); ?>
		</p>
	</div>

<?php else : ?>
	<?php if ($announcement['Announcement']['content'] !== '') : ?>
		<div>
			<?php echo $announcement['Announcement']['content']; ?>
		</div>
	<?php endif; ?>

<?php endif;
