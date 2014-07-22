
	<h3><?php echo __("記事変更通知"); ?></h3>
	<form>
		<h4><?php echo __("送信設定"); ?></h4>
		<input type="radio" name="is_send" value="1" checked> <?php echo __("送信する"); ?>
		<input type="radio" name="is_send" value="0"> <?php echo __("送信しない"); ?>
		<h4><?php echo __('送信先設定'); ?></h4>
		<?php
		foreach($partList as $key=>$item){
		?><span style="display:block; float:left; margin-right: 10px;">
			<input type="checkbox" name="part_id_<?php echo h($item['AnnouncementRoomPart']['part_id']); ?>"> <?php
			echo h($item["LanguagesPart"]['name']) . "</span>";
			}
			?>
			<p style="clear:both;"></p>

						<h4><?php echo __('メール文書設定'); ?></h4>
							<div>
								<p>
									<?php echo __('タイトル'); ?> :
									<input type="text" class="form-control" name="subject">
								</p>
								<p>
									<?php echo __('本文'); ?> :
									<textarea class="form-control" rows="10" name="body"><?php
										echo $this->element("Announcements.setting/message_sample_update"); ?>
									</textarea>
								</p>
							</div>
	</form>
	<pre><?php
		//説明
		echo $this->element("Announcements.setting/message_info"); ?></pre>



	<p class="text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('キャンセル'); ?></button>
		<button type="button" class="btn btn-primary"
		        ng-click="partSend('updateMessage',<?php echo $frameId; ?>,<?php echo $blockId; ?>,<?php echo $langId; ?>)"
			><span><?php echo __('更新する'); ?></span></button>
	</p>
