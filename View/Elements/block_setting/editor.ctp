<?php
// ルーム管理者の画面
?>
<!-- Modal -->
<div ng-controller="Announcements.setting">

	<div class="modal fade" id="nc-block-setting-<?php echo $frameId; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div  class="modal-dialog nc-modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="myModalLabel"><?php echo __('Announcements Plugin');?>  <?php echo __('Block setting'); ?></h3>
				</div>
				<div class="modal-body">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#nc-announcements-block-setting-update-<?php echo $frameId; ?>"
							role="tab"
							data-toggle="tab"><?php echo __('Articles change notification setting'); ?></a></li>
						<li><a href="#nc-announcements-block-setting-request-<?php echo $frameId; ?>'
							role="tab"
							data-toggle="ab"><?php echo __('Publication request notification settings'); ?></a>
						</li>
					</ul>
					<!-- end Nav tabs -->

					<!-- Tab panes -->
					<div class="tab-content">

						<?php
						//更新メッセージ設定
						?><div class="tab-pane" id="nc-announcements-block-setting-update-<?php echo $frameId; ?>"><?php
							echo $this->element('Announcements.setting/message_update_form');
							?></div>

						<?php
						//申請メッセージ設定
						?><div class="tab-pane" id="nc-announcements-block-setting-request-<?php echo $frameId; ?>"><?php
							echo $this->element("Announcements.setting/message_publish_form");
						?></div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="nc-announcements-block-setting-get-edit-form-<?php echo $frameId; ?>"></div>
</div>
