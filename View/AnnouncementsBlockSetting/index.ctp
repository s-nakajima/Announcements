<!-- Modal -->
<div class="modal fade" id="block-setting-<?php echo intval($frameId); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div style="width: 90%;" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="myModalLabel"><?php echo __('お知らせ機能');?>  <?php echo __("ブロック設定"); ?></h3>
			</div>
			<div class="modal-body">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li class="active">
						<a href="#announcements-block-setting-parts-<?php echo intval($frameId); ?>" role="tab" data-toggle="tab">権限管理</a></li>
					<li><a href="#announcements-block-setting-update-<?php echo intval($frameId); ?>" role="tab" data-toggle="tab">記事変更通知</a></li>
					<li><a href="#announcements-block-setting-request-<?php echo intval($frameId); ?>" role="tab" data-toggle="tab">公開申請通知</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane active" id="announcements-block-setting-parts-<?php echo intval($frameId); ?>">
							<h3><?php echo __("公開権限管理"); ?></h3>
						<p class="container">
						<?php
							foreach($partList as $key=>$item){
								if ($item['roomParts']['can_publish_content'] == 1) {
									echo '<span class="glyphicon glyphicon-ok"></span>';
								} elseif ($item['roomParts']['can_publish_content'] == 0) {
									echo '<span class="glyphicon glyphicon-remove"></span>';
								}
								elseif ($item['roomParts']['can_publish_content'] == 2) {
									?><input type="checkbox"><?php
								}
								echo h($item['languagesParts']['name']) . "<br>";
							}
						?></p>
						<h4>編集権限管理</h4>
						<p class="container">
						<?php
						foreach($partList as $key=>$item){
							if ($item['roomParts']['can_edit_content'] == 1 && $item['roomParts']['part_id'] != 1) {
								echo '<input type="checkbox">';
							}
							elseif ($item['roomParts']['part_id'] == 1) {
								//ルーム管理者
								echo '<span class="glyphicon glyphicon-ok"></span>';
							}
							elseif ($item['roomParts']['can_edit_content'] == 0) {
								echo '<span class="glyphicon glyphicon-remove"></span>';
							}
							echo h($item['languagesParts']['name']) . "<br>";
						}
						?></p>
						<p class="text-center">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("キャンセル"); ?></button>
							<button type="button" class="btn btn-primary"><span><?php echo __("更新する"); ?></span></button>
						</p>
					</div>

					<div class="tab-pane" id="announcements-block-setting-update-<?php echo intval($frameId); ?>">
						<h3><?php echo __("記事変更通知"); ?></h3>
						<form>
						<h4><?php echo __("送信設定"); ?></h4>
							<input type="radio" name="send" value="1" checked> <?php echo __("送信する"); ?>
							<input type="radio" name="send" value="0"> <?php echo __("送信しない"); ?>
						<h4><?php echo __('送信先設定'); ?></h4>
							<?php
							foreach($partList as $key=>$item){
								?><span style="display:block; float:left; margin-right: 10px;"><input type="checkbox"> <?php
								echo h($item['languagesParts']['name']) . "</span>";
							}
							?>
							<p style="clear:both;"></p>

						<h4><?php echo __('メール文書設定'); ?></h4>
							<div>
							<p>
								<?php echo __('タイトル'); ?> :
								<input type="text" class="form-control">
							</p>
							<p>
								<?php echo __('本文'); ?> :
								<textarea class="form-control" rows="10"></textarea>
							</p>
							</div>
						</form>
						<pre>
件名と本文には、
{X-SITE_NAME}、{X-ROOM}、
{X-JOURNAL_NAME}、{X-CATEGORY_NAME}、{X-SUBJECT}、{X-USER}、
{X-TO_DATE}、{X-BODY}、{X-URL}
というキーワードを使えます。
それぞれのキーワードは、
サイト名称、ルーム名称、
日誌名称、カテゴリ、記事タイトル、投稿者ハンドル名称、
投稿日時、記事本文、投稿内容のURL
に変換されて送信されます。
						</pre>



						<p class="text-center">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('キャンセル'); ?></button>
							<button type="button" class="btn btn-primary"><span><?php echo __('更新する'); ?></span></button>
						</p>
					</div>

					<div class="tab-pane" id="announcements-block-setting-request-<?php echo intval($frameId); ?>">
						<h3><?php echo __('公開申請通知'); ?></h3>

						<form>
							<h4><?php echo __('送信設定'); ?></h4>
							<input type="radio" name="send" value="1" checked> <?php echo __('送信する'); ?>
							<input type="radio" name="send" value="0"> <?php echo __('送信しない'); ?>

							<h4><?php echo __('メール文書設定'); ?></h4>
							<div>
							<p>
								<?php echo __('タイトル'); ?> :
								<input type="text" class="form-control">
							</p>
							<p>
								<?php echo __('本文'); ?> :
								<textarea class="form-control" rows="10">
日誌に投稿されたのでお知らせします。
ルーム名称:{X-ROOM}
投稿者:{X-USER}
投稿日時:{X-TO_DATE}
この記事に返信するには、下記アドレスへ
{X-URL}
								</textarea>
							</p>
							</div>
						</form>
						<pre>
件名と本文には、
{X-SITE_NAME}、{X-ROOM}、
{X-JOURNAL_NAME}、{X-CATEGORY_NAME}、{X-SUBJECT}、{X-USER}、
{X-TO_DATE}、{X-BODY}、{X-URL}
というキーワードを使えます。
それぞれのキーワードは、
サイト名称、ルーム名称、
日誌名称、カテゴリ、記事タイトル、投稿者ハンドル名称、
投稿日時、記事本文、投稿内容のURL
に変換されて送信されます。
						</pre>




						<p class="text-center">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('キャンセル'); ?></button>
							<button type="button" class="btn btn-primary"><span><?php echo __('更新する'); ?></span></button>
						</p>
					</div>


				</div>


			</div>
		</div>
	</div>
</div>
