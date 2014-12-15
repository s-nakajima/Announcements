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
	<?php echo $this->Html->script('/net_commons/base/js/workflow.js', false); ?>
	<?php echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false); ?>
	<?php echo $this->Html->script('/announcements/js/announcements.js', false);?>

	<div id="nc-announcements-<?php echo (int)$frameId; ?>"
		 ng-controller="Announcements"
		 ng-init="initialize(<?php echo (int)$frameId; ?>,
								<?php echo h(json_encode($announcement)); ?>)">

		<p class="text-right">
			<?php if ($contentPublishable) : ?>
				<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Accept'); ?>">
					<button type="button" class="btn btn-warning ng-hide"
							ng-hide="(announcement.Announcement.status !== '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>')"
							ng-disabled="sending"
							ng-click="publish();">

						<span class="glyphicon glyphicon-ok"></span>
					</button>
				</span>
			<?php endif; ?>

			<?php echo $this->element('NetCommons.setting_button'); ?>
		</p>

		<div ng-bind-html="htmlContent()"></div>

		<p class="text-left">
			<?php echo $this->element('NetCommons.status_label',
					array('statusModel' => 'announcement.Announcement.status')); ?>
		</p>
	</div>

<?php else : ?>
	<?php if ($announcement['Announcement']['content'] !== '') : ?>
		<div>
			<?php echo $announcement['Announcement']['content']; ?>
		</div>
	<?php endif; ?>

<?php endif;
