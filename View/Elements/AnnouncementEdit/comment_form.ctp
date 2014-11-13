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
				ng-class="getNgClassComment(<?php echo ($formName); ?>)">

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
							'class' => 'form-control nc-noresize',
							'ng-model' => 'edit.data.Comment.comment',
							'placeholder' => __d('net_commons', 'Please enter comments to the person in charge.'),
							'autofocus' => 'true',
							'ng-required' => "(edit.data.Announcement.status === '" . NetCommonsBlockComponent::STATUS_DISAPPROVED . "')",
						)
					); ?>

			<div class="form-control-feedback"
					ng-class="<?php echo ($formName); ?>.comment.$invalid ?
									'glyphicon glyphicon-remove' : 'glyphicon glyphicon-ok'; "
					ng-show="(edit.data.Announcement.status === '<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>')">
			</div>

			<div class="help-block">
				<br ng-hide="(edit.data.Announcement.status === '<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>' &&
							<?php echo ($formName); ?>.comment.$invalid)" />

				<div ng-show="(edit.data.Announcement.status === '<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>' &&
							<?php echo ($formName); ?>.comment.$invalid)">
					<?php echo __d('net_commons', 'If it is not approved, comment is a required input.'); ?>
				</div>

			</div>
		</div>
	</div>
</div>
