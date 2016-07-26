<?php
/**
 * announcements edit form element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->element('Blocks.form_hidden'); ?>

<?php echo $this->NetCommonsForm->hidden('Announcement.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Announcement.key'); ?>
<?php echo $this->NetCommonsForm->hidden('Announcement.block_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Announcement.language_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Announcement.status'); ?>

<?php echo $this->NetCommonsForm->hidden('AnnouncementSetting.use_workflow'); ?>

<?php echo $this->NetCommonsForm->wysiwyg('Announcement.content', array(
		'label' => __d('announcements', 'Content'),
		'required' => true,
	)); ?>

<?php if (Current::permission('block_editable')) : ?>
	<?php echo $this->element('Blocks.public_type'); ?>
	<?php echo $this->element(
			'Blocks.modifed_info',
			array('displayModified' => (bool)Hash::get($this->request->data, 'Announcement.id'))
		); ?>
<?php endif;