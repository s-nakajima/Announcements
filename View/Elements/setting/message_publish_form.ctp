<h3><?php echo __('Publication request notification settings'); ?></h3>

	<form>
		<h4><?php echo __('Mail Notification settings'); ?></h4>
		<input type='radio' name='is_send' value='1' checked> <?php echo __('Send'); ?>
		<input type='radio' name='is_send' value='0'> <?php echo __('Do not send'); ?>

		<h4><?php echo __('Mail document setting'); ?></h4>
		<div>
			<p>
				<?php echo __('Mail Title'); ?> :
				<input type='text' name='subject' class='form-control'>
			</p>
			<p>
				<?php echo __('Mail Body'); ?> :
				<textarea class='form-control' rows='10'
					name='body'
				><?php
					echo $this->element('Announcements.setting/message_sample_publish'); ?></textarea>
			</p>
		</div>
	</form>
	<pre><?php
		//説明
		echo $this->element('Announcements.setting/message_info'); ?></pre>

	<p class='text-center'>
		<button type='button' class='btn btn-default' data-dismiss='modal'><?php echo __('Cancel'); ?></button>
		<button type='button' class='btn btn-primary'
				ng-click='partSend("publishMessage",<?php echo (int)$frameId; ?>,<?php echo (int) $blockId; ?>)'
			><span><?php echo __('Update'); ?></span></button>
	</p>
