<?php $roomPartKey = 'LanguagesPart'; ?>
	<h3><?php echo __d('announcements', 'Articles change notification'); ?></h3>
	<form>
		<h4><?php echo __d('announcements', 'Notification settings'); ?></h4>
		<input type="radio" name="is_send" value="1" checked> <?php echo __d('announcements', 'Send'); ?>
		<input type="radio" name="is_send" value="0"> <?php echo __d('announcements', 'Do not send'); ?>
		<h4><?php echo __d('announcements', 'Mail destination setting'); ?></h4>
			<?php
			foreach ($partList as $key => $item) {
				$partId = $item[$roomPartKey]['part_id'];
				?>
				<span style='display:block; float:left; margin-right: 10px;'>
					<input type="checkbox"
						name="part_id_<?php echo h($item[$roomPartKey]['part_id']); ?>"
						id="nc-announcements-message-update-frame-<?php
							echo (int)$frameId; ?>-part-<?php
							echo (int)$partId; ?>"
						ng-click="partChange( 'message-update' ,
								<?php echo (int)$frameId; ?>,
								<?php echo (int)$partId; ?>
							)"
						checked=""
						value="<?php echo (int)$partId; ?>">
						<?php echo h($item[$roomPartKey]['name']); ?>
				</span>
				<?php
			} ?>
				<p style='clear:both;'></p>

				<h4><?php echo __d('announcements', 'Mail document setting'); ?></h4>
			<div>
				<p>
					<?php echo __d('announcements', 'Mail Title'); ?> :
					<input type='text' class='form-control' name='subject'>
				</p>
				<p>
					<?php echo __d('announcements', 'Mail Body'); ?> :
					<textarea class='form-control' rows='10' name='body'><?php
						echo $this->element('Announcements.setting/message_sample_update'); ?>
					</textarea>
				</p>
			</div>
	</form>

	<pre>
		<?php echo $this->element('Announcements.setting/message_info'); ?>
	</pre>

	<p class="text-center">
		<button type="button" class="btn btn-default"
				data-dismiss="modal">
				<?php echo __d('announcements', 'Cancel'); ?>
		</button>
		<button type='button' class='btn btn-primary'
				ng-click='partSend("updateMessage",
					<?php echo (int)$frameId; ?>,
					<?php echo (int)$blockId; ?>,
					<?php echo (int)$langId; ?>)'>
			<span><?php echo __d('announcements', 'Update'); ?></span>
		</button>
	</p>
