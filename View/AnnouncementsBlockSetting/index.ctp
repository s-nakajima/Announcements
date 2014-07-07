<!-- Modal -->
<div class="modal fade" id="block-setting-<?php echo intval($frameId); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div style="width: 90%;" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">お知らせ機能 ブロック設定</h4>
			</div>
			<div class="modal-body">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li class="active">
						<a href="#announcements-block-setting-parts-<?php echo intval($frameId); ?>" role="tab" data-toggle="tab">権限管理</a></li>
					<li><a href="#announcements-block-setting-send-<?php echo intval($frameId); ?>" role="tab" data-toggle="tab">メール送信設定</a></li>
					<li><a href="#announcements-block-setting-message-<?php echo intval($frameId); ?>" role="tab" data-toggle="tab">メールテンプレート</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane active container" id="announcements-block-setting-parts-<?php echo intval($frameId); ?>">
							<h4>公開権限管理</h4>
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
							if ($item['roomParts']['can_edit_content'] == 1) {
								echo '<span class="glyphicon glyphicon-ok"></span>';
							} elseif ($item['roomParts']['can_edit_content'] == 0) {
								echo '<span class="glyphicon glyphicon-remove"></span>';
							}
							elseif ($item['roomParts']['can_edit_content'] == 2) {
								?><input type="checkbox"><?php
							}
							echo h($item['languagesParts']['name']) . "<br>";
						}
						?></p>
						<p class="text-center">
							<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
							<button type="button" class="btn btn-primary"><span>更新する</span></button>
						</p>
					</div>
					<div class="tab-pane container" id="announcements-block-setting-send-<?php echo intval($frameId); ?>">
						<h4>メール送信設定</h4>
						<p class="container">
							<input type="radio" value="1"> 更新をメールで通知する <br>
							<input type="radio" value="0"> 更新をメールで通知しない。
						</p>
						<h4>送信先設定</h4>
						<p class="container">
							<?php
							foreach($partList as $key=>$item){
								?><input type="checkbox"><?php
								echo h($item['languagesParts']['name']) . "<br>";
							}
							?>
							<input type="checkbox"> 最終編集者本人
						</p>
						<p class="text-center">
							<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
							<button type="button" class="btn btn-primary"><span>更新する</span></button>
						</p>

					</div>
					<div class="tab-pane" id="announcements-block-setting-message-<?php echo intval($frameId); ?>">
						<h4>メールテンプレート</h4>
						<div>
						<form>
							<p>
							タイトル:
							<input type="text" class="form-control" value="[{X-SITE_NAME}]お知らせ更新通知">
							</p>
							<p>
								本文
							<textarea class="form-control" rows="5">
お知らせが更新されましたので通知致します。
投稿者:{X-USER}
投稿日時:{X-TO_DATE}

{X-BODY}

この記事を確認する場合は下記アドレスへ
{X-URL}
							</textarea> </p>
							<pre>
件名と本文には、
{X-SITE_NAME}、{X-ROOM}、
{X-SUBJECT}、{X-USER}、
{X-TO_DATE}、{X-BODY}、{X-URL}
というキーワードを使えます。
それぞれのキーワードは、
サイト名称、ルーム名称、
掲示板名称、記事タイトル、投稿者ハンドル名称、
投稿日時、記事本文、投稿内容のURL
に変換されて送信されます。
							</pre>
						</form>
						</div>
						<p class="text-center">
							<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
							<button type="button" class="btn btn-primary"><span>更新する</span></button>
						</p
					</div>
				</div>
			</div>

		</div>
	</div>
</div>