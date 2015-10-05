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

<div class="block-setting-body"
	ng-controller="Announcements"
	ng-init="initialize(<?php echo h(json_encode($announcement)); ?>)">

	<?php echo $this->Block->mainTabs(BlockTabsComponent::MAIN_TAB_BLOCK_INDEX); ?>

	<div class="tab-content">
		<?php echo $this->Block->blockTabs(BlockTabsComponent::BLOCK_TAB_SETTING); ?>

		<?php echo $this->element('Announcements.AnnouncementBlocks/edit_form'); ?>

		<?php echo $this->Workflow->comments(); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'model' => 'AnnouncementBlocks',
					'action' => NetCommonsUrl::actionUrl(array(
						'controller' => $this->params['controller'],
						'action' => 'delete',
						'block_id' => Current::read('Block.id'),
						'frame_id' => Current::read('Frame.id')
					)),
					'callback' => 'Announcements.AnnouncementBlocks/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</div>
