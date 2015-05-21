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
	ng-init="initialize(<?php echo h(json_encode(array('announcement' => $this->viewVars['announcement']))); ?>)">

	<div class="modal-body">
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
					<?php echo $this->element('Announcements/edit_form'); ?>

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
