<?php
/**
 * announcement setting view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php $formName = 'AnnouncementForm' . (int)$frameId; ?>

<?php $this->start('titleForModal'); ?>
<?php echo __d('announcements', 'plugin_name'); ?>
<?php $this->end(); ?>

<?php $this->startIfEmpty('tabList'); ?>
<li ng-class="{active:tab.isSet(0)}">
	<a href="" role="tab" data-toggle="tab">
		<?php echo __d('announcements', 'Announcement edit'); ?>
	</a>
</li>
<?php $this->end(); ?>

<div ng-show="tab.isSet(0)">
	<?php echo $this->Form->create('Announcement' . (int)$frameId, array(
			'type' => 'get',
			'name' => $formName,
			'novalidate' => true,
		)); ?>

		<div class="panel panel-default" ng-init="initialize(<?php echo $formName; ?>)">
			<div class="panel-body has-feedback">
				<?php echo $this->element('edit_form'); ?>

				<hr />

				<?php echo $this->element('Comments.form'); ?>
			</div>

			<div class="panel-footer text-center">
				<?php echo $this->element('NetCommons.workflow_buttons'); ?>
			</div>
		</div>

		<?php echo $this->element('Comments.index'); ?>

	<?php echo $this->Form->end(); ?>
</div>

