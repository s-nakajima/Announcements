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

<div class="form-group" ng-class="edit.data.Announcement.content === '' ? 'has-error' : 'has-success'">
	<label class="control-label">
		<?php echo __d('announcements', 'Content'); ?>
	</label>
	<span class="label label-danger">
		<?php echo __d('net_commons', 'Required'); ?>
	</span>

	<div class="nc-wysiwyg-alert" ng-class="edit.data.Announcement.content === '' ? 'alert-danger' : 'alert-success'">
		<textarea class="form-control" rows="5"
				ui-tinymce="tinymceOptions"
				ng-model="edit.data.Announcement.content">
		</textarea>
	</div>

	<div class="help-block">
		<br ng-hide="(edit.data.Announcement.content === '')" />
		<div ng-show="(edit.data.Announcement.content === '')">
			<?php echo (sprintf(__d('net_commons', 'Please input %s.'), __d('announcements', 'Content'))); ?>
		</div>
	</div>
</div>

