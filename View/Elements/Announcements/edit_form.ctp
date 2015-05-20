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

<div class="form-group">
	<label class="control-label">
		<?php echo __d('announcements', 'Content'); ?>
	</label>
	<?php echo $this->element('NetCommons.required'); ?>

	<div class="nc-wysiwyg-alert">
		<?php echo $this->Form->textarea(
			'Announcement.content', [
				'class' => 'form-control',
				'ui-tinymce' => 'tinymce.options',
				'ng-model' => 'announcements.content',
				'rows' => 5,
				'required' => 'required',
			]) ?>
	</div>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'Announcement',
			'field' => 'content',
		]) ?>
</div>

