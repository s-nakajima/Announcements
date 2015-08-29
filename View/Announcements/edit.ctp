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
	'/net_commons/js/wysiwyg.js',
	'/announcements/js/announcements.js'
));

$announcement = NetCommonsAppController::camelizeKeyRecursive(array('announcement' => $this->data['Announcement']));
?>

<div ng-controller="Announcements"
	ng-init="initialize(<?php echo h(json_encode($announcement)); ?>)">

	<div class="modal-body">
		<?php echo $this->Form->create('Announcement', array('novalidate' => true)); ?>

			<div class="panel panel-default" >
				<div class="panel-body">
					<?php echo $this->element('Announcements/edit_form'); ?>

					<hr />

					<?php echo $this->element('Comments.form', array('contentStatus' => $this->data['Announcement']['status'])); ?>
				</div>

				<div class="panel-footer text-center">
					<?php echo $this->element('NetCommons.workflow_buttons', array('contentStatus' => $this->data['Announcement']['status'])); ?>
				</div>
			</div>

			<?php echo $this->element('Comments.index'); ?>

		<?php echo $this->Form->end(); ?>
	</div>
</div>
