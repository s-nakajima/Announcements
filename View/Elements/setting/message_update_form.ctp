<?php
 $roomPartKey = 'LanguagesPart';
?>
	<h3><?php echo __('Articles change notification'); ?></h3>
	<form>
		<h4><?php echo __('Notification settings'); ?></h4>
		<input type='radio' name='is_send' value='1' checked> <?php echo __('Send'); ?>
		<input type='radio' name='is_send' value='0'> <?php echo __('Do not send'); ?>
		<h4><?php echo __('Destination setting'); ?></h4>
		<?php
		foreach ($partList as $key => $item) {
			$partId = $item[$roomPartKey]['part_id'];
		?><span style='display:block; float:left; margin-right: 10px;'>
			<input
				type='checkbox'
				name='part_id_<?php echo h($item[$roomPartKey]['part_id']); ?>'
				id='nc-announcements-message-update-frame-<?php echo (int) $frameId; ?>-part-<?php echo (int) $partId; ?>'
				ng-click='partChange("message-update" ,<?php echo (int) $frameId; ?>,<?php echo (int) $partId; ?>)'
			    checked=''
			    value='<?php echo (int) $partId; ?>'
			> <?php
			echo h($item[$roomPartKey]['name']) . '</span>';
			}
			?>
			<p style='clear:both;'></p>

						<h4><?php echo __('Mail document setting'); ?></h4>
							<div>
								<p>
									<?php echo __('Mail Title'); ?> :
									<input type='text' class='form-control' name='subject'>
								</p>
								<p>
									<?php echo __('Mail Body'); ?> :
									<textarea class='form-control' rows='10' name='body'><?php
										echo $this->element('Announcements.setting/message_sample_update'); ?>
									</textarea>
								</p>
							</div>
	</form>
	<pre><?php
		//説明
		echo $this->element('Announcements.setting/message_info'); ?></pre>

	<p class='text-center'>
		<button type='button' class='btn btn-default' data-dismiss='modal'><?php echo __('Cancel'); ?></button>
		<button type='button' class='btn btn-primary'
		        ng-click='partSend("updateMessage",<?php echo (int) $frameId; ?>,<?php echo (int) $blockId; ?>,<?php echo (int) $langId; ?>)'
			><span><?php echo __('Update'); ?></span></button>
	</p>
