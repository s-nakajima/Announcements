<div>
	<?php
	// TODO: 記事投稿権限、通知する権限の動作、disableにするかどうか。「投稿をメールで通知する」かどうかによる表示・非表示に切り替え未実装。
		echo $this->Form->create('AnnouncementBlock', array('ng-submit' => 'submit($event)', 'class' => 'form-horizontal announcements-block-setting-outer', 'role' => 'form'));
	?>
	<div class="modal-header">
		<button type="button" class="close" aria-hidden="true" ng-click="cancel()">&times;</button>
		<h4 class="modal-title"><?php echo __d('announcements', 'Announcement block setting'); ?></h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<?php
				echo $this->Form->label('Block.title', __d('announcements', 'Announcement Title') . '<span class="text-primary">*</span>', array('class' => 'col-sm-3 control-label'));
			?>
			<?php
				echo $this->Form->input('Block.title', array('label' => false, 'div' => 'col-sm-9'));
			?>
		</div>
		<div class="form-group">
			<?php
				echo $this->Form->label('AnnouncementBlocksPart.0.can_edit_content', __d('announcements', 'Authority to post articles'), array('class' => 'col-sm-3 control-label'));
			?>
			<div class="col-sm-9">
				<?php echo $this->Form->input('AnnouncementBlocksPart.0.can_edit_content', array('type' => 'checkbox', 'label' => __d('announcements', 'Room manager'))); ?>
				<?php echo $this->Form->input('AnnouncementBlocksPart.1.can_edit_content', array('type' => 'checkbox', 'label' => __d('announcements', 'Managing editor'))); ?>
				<?php echo $this->Form->input('AnnouncementBlocksPart.2.can_edit_content', array('type' => 'checkbox', 'label' => __d('announcements', 'Editor'))); ?>
				<?php echo $this->Form->input('AnnouncementBlocksPart.3.can_edit_content', array('type' => 'checkbox', 'label' => __d('announcements', 'General'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php
				echo $this->Form->label('AnnouncementBlocksPart.0.can_publish_content.1', __d('announcements', 'Post approval setting'), array('class' => 'col-sm-3 control-label'));
			?>
			<div class="col-sm-9">
				<?php
					echo $this->Form->input('AnnouncementBlocksPart.0.can_publish_content', array(
						'id' => 'AnnouncementBlocksPart0CanPublishContent',
						'type' => 'radio',
						'options' => array(1 => __d('announcements', 'Need room manager approval'), 0 => __d('announcements', 'Automatic approval')),
						'div' => 'radio',
						'separator' => '</div><div class="radio">',
						'legend' => false,
					));
				?>
			</div>
		</div>
		<div class="form-group">
			<?php
				echo $this->Form->label('AnnouncementBlock.send_mail.1', __d('announcements', 'Deliver e-mail when submitted?'), array('class' => 'col-sm-3 control-label'));
			?>
			<div class="col-sm-9">
				<?php
					echo $this->Form->input('AnnouncementBlock.send_mail', array(
						'type' => 'radio',
						'options' => array(1 => __d('announcements', 'Yes'), 0 => __d('announcements', 'No')),
						'div' => 'radio',
						'separator' => '</div><div class="radio">',
						'legend' => false,
						'ng-click' => 'toggleSendMail()',
					));
				?>
				<div ng-hide="toggleSendMailDetail">
					<?php
						echo $this->Form->label('AnnouncementBlocksPart.0.can_send_mail.1', __d('announcements', 'Notify whom? :'));
					?>
					<div>
						<?php echo $this->Form->input('AnnouncementBlocksPart.0.can_send_mail', array('type' => 'checkbox', 'label' => __d('announcements', 'Room manager'))); ?>
						<?php echo $this->Form->input('AnnouncementBlocksPart.1.can_send_mail', array('type' => 'checkbox', 'label' => __d('announcements', 'Managing editor'))); ?>
						<?php echo $this->Form->input('AnnouncementBlocksPart.2.can_send_mail', array('type' => 'checkbox', 'label' => __d('announcements', 'Editor'))); ?>
						<?php echo $this->Form->input('AnnouncementBlocksPart.3.can_send_mail', array('type' => 'checkbox', 'label' => __d('announcements', 'General'))); ?>
						<?php echo $this->Form->input('AnnouncementBlocksPart.4.can_send_mail', array('type' => 'checkbox', 'label' => __d('announcements', 'Visitor'))); ?>
					</div>
					<?php
						echo $this->Form->label('AnnouncementBlock.mail_subject', __d('announcements', 'E-mail Subject:'));
						echo $this->Form->input('AnnouncementBlock.mail_subject', array('label' => false, 'div' => false));
					?>
					<div>
						<?php echo $this->Form->label('AnnouncementBlock.mail_body', __d('announcements', 'Message：'));?>
					</div>
					<?php echo $this->Form->input('AnnouncementBlock.mail_body', array('type' => 'textarea', 'label' => false));?>
					<div>
						<?php echo __d('announcements', 'You may use the following keywords in the title and content of the message, {X-SITE_NAME}, {X-ROOM}, {X-ANNOUNCEMENT_NAME}, {X-USER}, {X-TO_DATE}, {X-BODY}, {X-URL}<br><br>Each keyword will be translated to site name, room name, announcement title, creator, timestamp, article and url');?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div class="text-center" >
			<?php echo $this->Form->button(__('Cancel'), array('class' => 'btn btn-default', 'type' => 'button', 'ng-click' => 'cancel()')); ?>
			<?php echo $this->Form->button(__('Ok'), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
		</div>
	</div>
	<?php
		echo $this->Form->end();
	?>
</div>
