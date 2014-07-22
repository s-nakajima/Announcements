<?php
// ルーム管理者の画面
?>
<!-- Modal -->
<div ng-controller="Announcements.setting">

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
						<li class="active"><a href="#announcements-block-setting-update-<?php echo intval($frameId); ?>"
						       role="tab"
						       data-toggle="tab"><?php echo __("記事変更通知"); ?></a></li>
						<li><a href="#announcements-block-setting-request-<?php echo intval($frameId); ?>"
						       role="tab"
						       data-toggle="tab"><?php echo __("公開申請通知"); ?></a>
						</li>
					</ul>
					<!-- end Nav tabs -->

					<!-- Tab panes -->
					<div class="tab-content">

						<?php
						//更新メッセージ設定
						?><div class="tab-pane" id="announcements-block-setting-update-<?php echo intval($frameId); ?>"><?php
							echo $this->element("Announcements.setting/message_update_form");
							?></div>

						<?php
						//申請メッセージ設定
						?><div class="tab-pane" id="announcements-block-setting-request-<?php echo intval($frameId); ?>"><?php
							echo $this->element("Announcements.setting/message_publish_form");
						?></div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="announcements-block-setting-get-edit-form-<?php echo $frameId; ?>"></div>
</div>
