<?php
// ルーム管理者の画面
?>
<!-- Modal -->

	<div  class="modal fade" id="nc-block-setting-<?php echo intval($frameId); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div ng-controller="Announcements.setting">
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
								<a href="#nc-announcements-block-setting-parts-publish-<?php echo intval($frameId); ?>"
									role="tab"
									data-toggle="tab"><?php echo __("公開権限設定"); ?></a></li>

							<li><a href="#nc-announcements-block-setting-parts-editor-<?php echo intval($frameId); ?>"
									role="tab"
									data-toggle="tab"><?php echo __("編集権限設定"); ?></a></li>
							<li><a href="#nc-announcements-block-setting-update-<?php echo intval($frameId); ?>"
									role="tab"
									data-toggle="tab"><?php echo __("記事変更通知"); ?></a></li>
							<li><a href="#nc-announcements-block-setting-request-<?php echo intval($frameId); ?>"
								role="tab"
								data-toggle="tab"><?php echo __("公開申請通知"); ?></a>
							</li>
					</ul>
					<!-- end Nav tabs -->

					<!-- Tab panes -->
					<div class="tab-content">

						<?php
							//ルーム管理者の承認が必要 :公開権限の編集はできない
							if(! $isNeedApproval) {
								?><div class="tab-pane active" id="nc-announcements-block-setting-parts-publish-<?php echo intval($frameId); ?>"><?php
								echo $this->element("Announcements.setting/parts_publish_form");
								?></div><?php
							}


						?><div class="tab-pane <?php if($isNeedApproval) { echo 'active'; } ?>" id="nc-announcements-block-setting-parts-editor-<?php echo intval($frameId); ?>"><?php
							echo $this->element("Announcements.setting/parts_editor_form");
						?></div>

						<?php
						//更新メッセージ設定
						?><div class="tab-pane" id="nc-announcements-block-setting-update-<?php echo intval($frameId); ?>"><?php
							echo $this->element("Announcements.setting/message_update_form");
						?></div>

						<?php
						//更新メッセージ設定
						?><div class="tab-pane" id="nc-announcements-block-setting-request-<?php echo intval($frameId); ?>"><?php
							echo $this->element("Announcements.setting/message_publish_form");
						?></div>

					</div>
				</div>
				<div id="nc-announcements-block-setting-get-edit-form-<?php echo $frameId; ?>"></div>
			</div>
		</div>

		</div>

	</div>


