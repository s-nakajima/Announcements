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

<?php if ($contentEditable) : ?>
	<div id="nc-announcements-<?php echo (int)$frameId; ?>"
		 ng-controller="Announcements"
		 ng-init="initialize(<?php echo (int)$frameId; ?>,
								<?php echo h(json_encode($announcement)); ?>)">

		<p class="text-right">
			<?php if ($contentPublishable) : ?>
				<button type="button" class="btn btn-warning ng-hide"
						tooltip="<?php echo __d('net_commons', 'Accept'); ?>"
						ng-controller="Announcements.edit"
						ng-hide="(announcement.Announcement.status !== '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>')"
						ng-click="initialize(); save('<?php echo NetCommonsBlockComponent::STATUS_PUBLISHED ?>')">

					<span class="glyphicon glyphicon-ok"></span>
				</button>
			<?php endif; ?>

			<button class="btn btn-primary"
					tooltip="<?php echo __d('net_commons', 'Manage'); ?>"
					ng-click="showManage()">

				<span class="glyphicon glyphicon-cog"> </span>
			</button>
		</p>

		<div ng-bind-html="htmlContent()"></div>

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
