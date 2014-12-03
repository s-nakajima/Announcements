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

<div class="form-group" ng-class="form.content.$invalid ? 'has-error' : 'has-success'">
	<label class="control-label">
		<?php echo __d('announcements', 'Content'); ?>
	</label>
	<?php echo $this->element('NetCommons.required'); ?>

	<div class="nc-wysiwyg-alert" ng-class="form.content.$invalid ? 'alert-danger' : 'alert-success'">
		<textarea name="content" class="form-control" rows="5"
				ui-tinymce="tinymce.options" required
				ng-change="serverValidationClear(form, 'content')"
				ng-model="edit.data.Announcement.content">
		</textarea>
	</div>

	<div class="help-block">
		<br ng-hide="form.content.$invalid" />
		<div ng-show="form.content.$invalid">
			<div ng-repeat="errorMessage in form.content.validationErrors">
				{{errorMessage}}
			</div>
			<div ng-if="! form.content.validationErrors">
				<?php echo sprintf(__d('net_commons', 'Please input %s.'), __d('announcements', 'Content')); ?>
			</div>
		</div>
	</div>
</div>

