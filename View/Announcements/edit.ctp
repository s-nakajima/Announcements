<?php
/**
 * announcement setting view template
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

$announcement = NetCommonsAppController::camelizeKeyRecursive(array('announcement' => $this->data['Announcement']));
?>

<article class="block-setting-body" ng-controller="Announcements"
	ng-init="initialize(<?php echo h(json_encode($announcement)); ?>)">

	<div class="panel panel-default" >
		<div class="panel-body">
			<?php echo $this->NetCommonsForm->create('Announcement'); ?>
				<?php echo $this->element('Announcements/edit_form'); ?>

				<hr />

				<?php echo $this->Workflow->inputComment('Announcement.status'); ?>
			</div>

			<?php echo $this->Workflow->buttons('Announcement.status', NetCommonsUrl::backToPageUrl()); ?>
		<?php echo $this->NetCommonsForm->end(); ?>

		<?php if ($this->Workflow->canDelete('Announcements.Announcement', $this->request->data) &&
						Hash::get($this->request->data, 'Announcement.id')) : ?>
			<div class="panel-footer text-right">
				<?php echo $this->element('Announcements.Announcements/delete_form', array(
					'url' => NetCommonsUrl::blockUrl(array('action' => 'delete', 'key' => $this->data['Announcement']['key']))
				)); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php echo $this->Workflow->comments(); ?>

</article>
