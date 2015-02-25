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
<?php echo $this->element('Wysiwyg.mathjax_config'); ?>
<?php echo $this->element('Wysiwyg.include_javascript'); ?>

<?php echo $this->Html->script('/net_commons/base/js/workflow.js', false); ?>
<?php echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false); ?>
<?php echo $this->Html->script('/announcements/js/announcements.js', false); ?>

<div id="nc-announcements-<?php echo (int)$frameId; ?>"
	 ng-controller="Announcements"
	 ng-init="initialize(<?php echo h(json_encode($this->viewVars)); ?>)">

	<p class="text-right">
		<?php echo $this->element('NetCommons.setting_button'); ?>
	</p>

	<?php echo isset($announcements['content']) ? $announcements['content'] : ''; ?>

	<p class="text-left">
		<?php echo $this->element('NetCommons.status_label',
				array('status' => 'announcements.status')); ?>
	</p>
</div>
