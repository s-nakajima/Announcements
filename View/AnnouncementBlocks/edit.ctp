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
?>

<?php
	$this->Html->script(
		array(
			'/net_commons/js/wysiwyg.js',
			'/announcements/js/announcements.js'
		),
		array(
			'plugin' => false,
			'inline' => false
		)
	);
?>

<div id="nc-announcements-<?php echo (int)$frameId; ?>" class="modal-body"
		ng-controller="Announcements"
		ng-init="initialize(<?php echo h(json_encode(array('announcement' => $this->viewVars['announcement']))); ?>)">

	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.setting_tabs', $blockSettingTabs); ?>

		<?php echo $this->element('Announcements.AnnouncementBlocks/edit_form'); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'controller' => 'AnnouncementBlocks',
					'action' => 'delete/' . $frameId . '/' . (int)$announcement['blockId'],
					'callback' => 'Announcements.AnnouncementBlocks/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</div>
