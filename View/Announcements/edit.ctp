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

<?php 
	$this->Html->script(
		array(
			'/net_commons/js/workflow.js',
			'/net_commons/js/wysiwyg.js',
			'/announcements/js/announcements.js'
		),
		array(
			'plugin' => false,
			'inline' => false
		)
	);
?>

<div id="nc-announcements-<?php echo (int)$frameId; ?>"
	ng-controller="Announcements"
	ng-init="initialize(<?php echo h(json_encode($this->viewVars)); ?>)">

	<?php $this->start('title'); ?>
	<?php echo __d('announcements', 'plugin_name'); ?>
	<?php $this->end(); ?>

	<?php $this->startIfEmpty('tabs'); ?>
	<li ng-class="{active:tab.isSet(0)}">
		<a href="" role="tab" data-toggle="tab">
			<?php echo __d('announcements', 'Announcement edit'); ?>
		</a>
	</li>
	<?php $this->end(); ?>

	<div class="modal-header">
		<?php $title = $this->fetch('title'); ?>
		<?php if ($title) : ?>
			<?php echo $title; ?>
		<?php else : ?>
			<br />
		<?php endif; ?>
	</div>

	<div class="modal-body">
		<?php $tabs = $this->fetch('tabs'); ?>
		<?php if ($tabs) : ?>
			<ul class="nav nav-tabs" role="tablist">
				<?php echo $tabs; ?>
			</ul>
			<br />
			<?php $tabId = $this->fetch('tabIndex'); ?>
			<div class="tab-content" ng-init="tab.setTab(<?php echo (int)$tabId; ?>)">
		<?php endif; ?>

		<div>
		<?php echo $this->Form->create('Announcement', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>
			<?php echo $this->Form->hidden('id'); ?>
			<?php echo $this->Form->hidden('Frame.id', array(
				'value' => $frameId,
			)); ?>
			<?php echo $this->Form->hidden('Block.id', array(
				'value' => $blockId,
			)); ?>

			<div class="panel panel-default" >
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
</div>
