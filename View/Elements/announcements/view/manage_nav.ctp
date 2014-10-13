<?php
/**
 * announcements manage_button elements
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-header">
	<button class="close" type="button"
			tooltip="<?php echo __d('announcements', 'Close'); ?>"
			ng-click="cancel()">
		<span class="glyphicon glyphicon-remove small"></span>
	</button>

	<ul class="nav nav-pills">
		<li class="active">
			<a href="#nc-announcements-edit-<?php echo $frameId; ?>"
					role="tab" data-toggle="tab" onclick="return false;">
				<?php echo __d('announcements', 'Announcement edit'); ?>
			</a>
		</li>
	</ul>
</div>