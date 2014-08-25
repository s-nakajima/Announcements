<?php
// room admin block setting.
?>
	<div  class='modal fade' id='nc-block-setting-<?php echo (int)$frameId; ?>' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
		<div ng-controller='Announcements.setting'>
		<div class='modal-dialog nc-modal-lg'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
					<h3 class='modal-title' id='myModalLabel'><?php echo __('Announcements Plugin');?>  <?php echo __('Block setting'); ?></h3>
				</div>
				<div class='modal-body'>
					<!-- Nav tabs -->
					<ul class='nav nav-tabs' role='tablist'>
							<li class='active'>
								<a href='#nc-announcements-block-setting-parts-publish-<?php echo (int)$frameId; ?>'
									role='tab'
									data-toggle='tab'><?php echo __('Publication control Settings'); ?></a></li>

							<li><a href='#nc-announcements-block-setting-parts-editor-<?php echo (int)$frameId; ?>'
									role='tab'
									data-toggle='tab'><?php echo __('Editorial control Settings'); ?></a></li>
							<li><a href='#nc-announcements-block-setting-update-<?php echo (int)$frameId; ?>'
									role='tab'
									data-toggle='tab'><?php echo __('Articles change notification'); ?></a></li>
							<li><a href='#nc-announcements-block-setting-request-<?php echo (int)$frameId; ?>'
								role='tab'
								data-toggle='tab'><?php echo __('Request  Notification settings'); ?></a>
							</li>
					</ul>
					<!-- end Nav tabs -->

					<!-- Tab panes -->
					<div class='tab-content'>
						<div class='tab-pane <?php if ($publishRoomAdminOnly) { echo 'active'; } ?>' id='nc-announcements-block-setting-parts-editor-<?php echo (int)$frameId; ?>'><?php
							echo $this->element('Announcements.setting/parts_editor_form');
						?></div>

						<?php
						?><div class='tab-pane' id='nc-announcements-block-setting-update-<?php echo (int)$frameId; ?>'><?php
							echo $this->element('Announcements.setting/message_update_form');
						?></div>

						<?php
						?><div class='tab-pane' id='nc-announcements-block-setting-request-<?php echo (int)$frameId; ?>'><?php
							echo $this->element('Announcements.setting/message_publish_form');
						?></div>

					</div>
				</div>
				<div id='nc-announcements-block-setting-get-edit-form-<?php echo (int)$frameId; ?>'></div>
			</div>
		</div>

		</div>

	</div>


