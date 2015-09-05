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

<?php if (CurrentUtility::permission('content_editable')) : ?>
	<p class="text-right">
		<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Edit'); ?>">
			<a href="<?php echo $this->Html->url('/announcements/announcements/edit/' . CurrentUtility::read('Frame.id')) ?>" class="btn btn-primary">
				<span class="glyphicon glyphicon-edit"> </span>
			</a>
		</span>
	</p>
<?php endif; ?>

<?php echo $announcement['content']; ?>

<?php if (CurrentUtility::permission('content_editable')) : ?>
	<p class="text-left">
		<?php echo $this->Workflow->label($announcement['status']); ?>
	</p>
<?php endif;
