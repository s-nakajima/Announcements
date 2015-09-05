<?php
/**
 * Blocks edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script(array(
	'/net_commons/js/wysiwyg.js',
	'/announcements/js/announcements.js'
));

$announcement = NetCommonsAppController::camelizeKeyRecursive(array('announcement' => $this->data['Announcement']));
?>

<div ng-controller="Announcements"
	ng-init="initialize(<?php echo h(json_encode($announcement)); ?>)">

	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.setting_tabs', $blockSettingTabs); ?>

		<?php echo $this->element('Announcements.AnnouncementBlocks/edit_form'); ?>

		<?php echo $this->Workflow->comments(); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'model' => 'AnnouncementBlocks',
					'action' => 'delete/' . $frameId . '/' . $blockId,
					'callback' => 'Announcements.AnnouncementBlocks/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</div>
