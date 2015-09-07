<?php
/**
 * Blocks edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->create('Announcement', array('novalidate' => true)); ?>

	<div class="panel panel-default" >
		<div class="panel-body has-feedback">
			<?php echo $this->element('Announcements/edit_form'); ?>

			<?php echo $this->element('Blocks.public_type'); ?>

			<hr />

			<?php echo $this->Workflow->inputComment('Announcement.status'); ?>
		</div>

		<?php echo $this->Workflow->buttons('Announcement.status', Current::backToIndexUrl('default_setting_action')); ?>
	</div>
<?php echo $this->Form->end();
