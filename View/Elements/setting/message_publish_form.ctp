<h3><?php echo __d('announcements', 'Publication request notification settings'); ?></h3>

	<form>
		<h4><?php echo __d('announcements', 'Mail Notification settings'); ?></h4>
		<input type="radio" name="is_send" value="1" checked> <?php echo __d('announcements', 'Send'); ?>
		<input type="radio" name="is_send" value="0"> <?php echo __d('announcements', 'Do not send'); ?>

		<h4><?php echo __d('announcements', 'Mail document setting'); ?></h4>
		<div>
			<p>
				<?php echo __d('announcements', 'Mail Title'); ?> :
				<input type="text" name="subject" class="form-control">
			</p>
			<p>
				<?php echo __d('announcements', 'Mail Body'); ?> :
				<textarea
					class="form-control"
					rows="10"
					name="body">
					<?php echo $this->element('Announcements.setting/message_sample_publish'); ?></textarea>
			</p>
		</div>
	</form>

	<pre><?php echo $this->element('Announcements.setting/message_info'); ?></pre>

	<p class="text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __d('announcements', 'Cancel'); ?></button>
		<button type="button" class="btn btn-primary"
				ng-click="partSend('publishMessage',<?php
				echo (int)$frameId; ?>,<?php
				echo (int)$blockId; ?>)">
				<span><?php
					echo __d('announcements', 'Update'); ?>
				</span>
		</button>
	</p>
