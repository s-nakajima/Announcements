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

echo $this->NetCommonsHtml->script(array(
	'/announcements/js/announcements.js'
));
?>

<div ng-controller="Sample">
	<a href="" ng-click="showUserSelectionDialog('<?php echo Current::read('User.id'); ?>')">会員選択</a>

	<div class="form-inline" ng-if="users.length">
		<span class="form-control" ng-repeat="user in users" style="margin: 5px; height: auto; padding: 3px 10px;">
			<a href="" ng-controller="Users.controller" ng-click="showUser(user.id)">
				<img class="user-avatar-xs" ng-src="{{user.avatar}}">
				{{user.handlename}}
			</a>
		</span>
	</div>
</div>

<?php if (Current::permission('content_editable')) : ?>
	<p class="text-right">
		<?php echo $this->Button->editLink(); ?>
	</p>
<?php endif; ?>

<?php echo $announcement['content']; ?>

<?php if (Current::permission('content_editable')) : ?>
	<p class="text-left">
		<?php echo $this->Workflow->label($announcement['status']); ?>
	</p>
<?php endif;
