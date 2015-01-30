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
		/* <textarea name="content" class="form-control" rows="5" */
		/* 		ui-tinymce="tinymce.options" required */
		/* 		ng-change="serverValidationClear(form, 'content')" */
		/* 		ng-model="announcement.content"><?php echo $announcement['content']; ?></textarea> */
?>

<div class="form-group">
	<label class="control-label">
		<?php echo __d('announcements', 'Content'); ?>
	</label>
	<?php echo $this->element('NetCommons.required'); ?>

	<div class="nc-wysiwyg-alert">
		<?php echo $this->Form->textarea('content',
					array(
						'class' => 'form-control',
						'ui-tinymce' => 'tinymce.options',
						'ng-model' => 'announcements.content',
						'rows' => 5,
						'required' => 'required',
					)) ?>
	</div>

	<div class="has-error">
		<?php if ($this->validationErrors['Announcement']): ?>
		<?php foreach ($this->validationErrors['Announcement']['content'] as $message): ?>
			<div class="help-block">
				<?php echo $message ?>
			</div>
		<?php endforeach ?>
		<?php endif ?>
	</div>
</div>

