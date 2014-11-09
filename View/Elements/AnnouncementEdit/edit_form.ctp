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

<div class="form-group" ng-class="errors.content ? 'has-error' : ''">
	<label class="control-label">
		<?php echo __d('net_commons', 'Content'); ?>
	</label>
	<span class="label label-danger">
		<?php echo __d('net_commons', 'Required'); ?>
	</span>

	<div class="nc-wysiwyg-alert" ng-class="errors.content ? 'alert-danger' : ''">
		<textarea class="form-control" rows="5"
				ui-tinymce="tinymceOptions"
				ng-model="edit.data.Announcement.content">
		</textarea>
	</div>

	<div class="help-block">
		<br ng-hide="errors.content" />
		<div ng-repeat="error in errors.content">
			{{error}}
		</div>
	</div>
</div>

