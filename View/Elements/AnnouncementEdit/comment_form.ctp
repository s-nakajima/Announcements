<?php
/**
 * announcements comment form element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="row">
	<div class="col-xs-offset-1 col-xs-11">
		<div class="form-group has-feedback"
				ng-class="getNgClassComment(<?php echo ('Announcement' . (int)$frameId); ?>)">

			<?php echo $this->Form->label('Announcement.comment',
						'<span class="glyphicon glyphicon-comment"></span> ' .
							__d('net_commons', 'Comments to the person in charge.'),
						array('class' => 'control-label')
					); ?>

			<span class="label label-info"> <?php echo __d('net_commons', 'Optional'); ?></span>

			<?php echo $this->Form->input('Announcement.comment', array(
							'label' => false,
							'rows' => '2',
							'type' => 'textarea',
							'class' => 'form-control',
							'ng-model' => 'edit.data.Announcement.comment',
							'placeholder' => __d('net_commons', 'Please enter comments to the person in charge.'),
							'autofocus' => 'true',
							'required' => 'true',
						)
					); ?>

			<div class="form-control-feedback"
					ng-class="errors.comment.$invalid ? 'glyphicon glyphicon-remove' : 'glyphicon glyphicon-ok'; "
					ng-show="errors.comment">
			</div>

			<div class="help-block">
				<div ng-show="(announcement.Announcement.status === '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>' && ! errors.comment)">
					<?php echo __d('net_commons', 'If it is not approved, comment is a required input.'); ?>
				</div>
				<br ng-show="(announcement.Announcement.status !== '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>' || errors.comment && ! errors.comment.$invalid)" />

				<div ng-repeat="error in errors.comment.messages" ng-show="errors.comment.$invalid">
					{{error}}
				</div>
			</div>
		</div>
	</div>
</div>
