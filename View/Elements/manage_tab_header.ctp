<?php
/**
 * announcements manage tab header template element
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
		<li <?php echo ($tab === 'edit' ? 'class="active"' : ''); ?>>
			<a href="#" ng-click="cancel(); changeTab('edit');">
				<?php echo __d('announcements', 'Announcement edit'); ?>
			</a>
		</li>
		<li <?php echo ($tab === 'displayChange' ? 'class="active"' : ''); ?>>
			<a href="#" ng-click="cancel(); changeTab('displayChange');">
				<?php echo __d('announcements', 'Display change'); ?>
			</a>
		</li>
	</ul>
</div>
