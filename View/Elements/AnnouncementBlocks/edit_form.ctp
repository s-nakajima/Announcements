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

<div class="panel panel-default" >
	<?php echo $this->NetCommonsForm->create('Announcement'); ?>
		<div class="panel-body">
			<?php echo $this->element('Announcements/edit_form'); ?>

			<hr />

			<?php echo $this->Workflow->inputComment('Announcement.status', false); ?>
		</div>

		<?php echo $this->Workflow->buttons('Announcement.status', NetCommonsUrl::backToIndexUrl('default_setting_action')); ?>
	<?php echo $this->NetCommonsForm->end(); ?>

	<?php if (Hash::get($this->request->data, 'Announcement.id')) : ?>
		<div class="panel-footer text-right">
			<?php echo $this->element('Announcements.Announcements/delete_form', array(
				'url' => NetCommonsUrl::actionUrl(array(
					'controller' => $this->params['controller'],
					'action' => 'delete',
					'block_id' => Current::read('Block.id'),
					'frame_id' => Current::read('Frame.id')
				))
			)); ?>
		</div>
	<?php endif; ?>
</div>
