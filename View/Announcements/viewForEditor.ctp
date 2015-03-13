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
title1: <?php echo isset($announcements['title1']) ? $announcements['title1'] : ''; ?>

<?php echo $this->Html->script('/net_commons/base/js/workflow.js', false); ?>
<?php echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false); ?>
<?php echo $this->Html->script('/announcements/js/announcements.js', false); ?>

<div id="nc-announcements-<?php echo (int)$frameId; ?>"
	 ng-controller="Announcements"
	 ng-init="initialize(<?php echo h(json_encode($this->viewVars)); ?>)">

	<p class="text-right">
		<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Edit'); ?>">
			<a href="<?php echo $this->Html->url('/announcements/announcements/edit/' . $frameId) ?>" class="btn btn-primary">
				<span class="glyphicon glyphicon-edit"> </span>
			</a>
		</span>
	</p>

	<?php echo isset($announcements['content']) ? $announcements['content'] : ''; ?>

	<p class="text-left">
		<?php echo $this->element('NetCommons.status_label',
				array('status' => 'announcements.status')); ?>
	</p>
</div>
