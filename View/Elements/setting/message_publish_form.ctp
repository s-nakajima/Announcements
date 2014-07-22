
	<h3><?php echo __('公開申請通知'); ?></h3>

	<form>
		<h4><?php echo __('送信設定'); ?></h4>
		<input type="radio" name="is_send" value="1" checked> <?php echo __('送信する'); ?>
		<input type="radio" name="is_send" value="0"> <?php echo __('送信しない'); ?>

		<h4><?php echo __('メール文書設定'); ?></h4>
		<div>
			<p>
				<?php echo __('タイトル'); ?> :
				<input type="text" name="subject" class="form-control">
			</p>
			<p>
				<?php echo __('本文'); ?> :
				<textarea class="form-control" rows="10"
					name="body"
				><?php
					echo $this->element("Announcements.setting/message_sample_publish"); ?></textarea>
			</p>
		</div>
	</form>
	<pre><?php
		//説明
		echo $this->element("Announcements.setting/message_info"); ?></pre>

	<p class="text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('キャンセル'); ?></button>
		<button type="button" class="btn btn-primary"
		        ng-click="partSend('publishMessage',<?php echo $frameId; ?>,<?php echo $blockId; ?>)"
			><span><?php echo __('更新する'); ?></span></button>
	</p>
