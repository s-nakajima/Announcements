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
	<header class="clearfix">
		<div class="pull-left">
			<?php echo $this->Workflow->label($announcement['status']); ?>
		</div>

		<div class="pull-right">
			<?php echo $this->Button->editLink(); ?>
		</div>
	</header>
<?php endif; ?>

<?php if ($announcement['content']) : ?>
	<?php echo $announcement['content']; ?>
<?php else : ?>
		<article>
			<?php echo __d('net_commons', 'Not found %s.', __d('announcements', 'Content')); ?>
		</article>
<?php endif;
