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

<?php endif; ?>

	<?php if ($contentEditable) : ?>
		<p class="text-right">
			<button class="btn btn-primary"
					tooltip="<?php echo __d('announcements', 'Manage'); ?>"
					ng-click="showManage()">

				<span class="glyphicon glyphicon-cog"> </span>
			</button>
		</p>
	<?php endif; ?>

	<?php if ($announcement['Announcement']['content'] !== '') : ?>
		<p>
			<?php echo $announcement['Announcement']['content']; ?>
		</p>
	<?php endif; ?>

	<?php if ($contentEditable) : ?>
		<p>
			<?php echo $this->element('Announcements/status_label'); ?>
		</p>
	<?php endif; ?>

<?php if ($contentEditable) : ?>
	</div>
<?php endif;