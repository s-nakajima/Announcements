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

<?php if (Current::permission('content_editable')) : ?>
	<p class="text-right">
		<?php echo $this->NetCommonsForm->editLinkButton(''); ?>
	</p>
<?php endif; ?>

<?php echo $announcement['content']; ?>

<?php if (Current::permission('content_editable')) : ?>
	<p class="text-left">
		<?php echo $this->Workflow->label($announcement['status']); ?>
	</p>
<?php endif;
