<?php
/**
 * announcement edit view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<p>
	<textarea required
			ui-tinymce="tinymceOptions"
			ng-model="announcement.Announcement.content">

	</textarea>
</p>

<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="cancel()">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('announcements', 'Close'); ?>
	</button>

	<?php if (isset($announcement['Announcements']) && $contentPublishable &&
				$announcement['Announcements']['status'] === NetCommonsBlockComponent::STATUS_APPROVED) : ?>
		<button type="button" class="btn btn-default"
				ng-click="save(<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>)">
			<?php echo __d('announcements', 'Disapproval'); ?>
		</button>

	<?php else : ?>
		<button type="button" class="btn btn-default"
				ng-click="save(<?php echo NetCommonsBlockComponent::STATUS_DRAFTED ?>)">
			<?php echo __d('announcements', 'Temporary'); ?>
		</button>

	<?php endif; ?>

	<?php if ($contentPublishable) : ?>
		<button type="button" class="btn btn-primary"
				ng-click="save(<?php echo NetCommonsBlockComponent::STATUS_PUBLISHED ?>)">
			<?php echo __d('announcements', 'Save'); ?>
		</button>

	<?php else : ?>
		<button type="button" class="btn btn-primary"
				ng-click="save(<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>)">
			<?php echo __d('announcements', 'Save'); ?>
		</button>

	<?php endif; ?>
</p>

