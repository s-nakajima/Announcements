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

<div class="row" ng-class="errors.comment ? 'has-error' : ''">
	<div class="col-xs-offset-1 col-xs-11">
		<?php echo $this->Form->label('Announcement.comment',
					'<span class="glyphicon glyphicon-comment"></span> ' .
						__d('net_commons', 'Comment'),
					array('class' => 'control-label')
				); ?>

		<span class="label label-info"> <?php echo __d('net_commons', 'Optional'); ?></span>

		<?php if (isset($announcement['Announcement']) && $contentPublishable &&
					$announcement['Announcement']['status'] === NetCommonsBlockComponent::STATUS_APPROVED) : ?>
			<span class="text-danger"
				  ng-hide="(announcement.Announcement.status !== '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>')">
				<?php echo __d('net_commons', 'If it is not approved, comment is a required input.'); ?>
			</span>
		<?php endif; ?>

		<?php echo $this->Form->input('Announcement.comment', array(
						'label' => false,
						'rows' => '2',
						'type' => 'textarea',
						'class' => 'form-control',
						'ng-model' => 'edit.data.Announcement.comment',
						'placeholder' => __d('net_commons', 'Please enter comments to the person in charge.'),
						'autofocus' => 'true',
					)
				); ?>
		<div class="help-block">
			<br ng-hide="errors.comment" />
			<div ng-repeat="error in errors.comment">
				{{error}}
			</div>
			<div ng-hide="errors.comment" ng-show="">

			</div>
		</div>
	</div>
</div>
