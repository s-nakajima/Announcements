<?php
/**
 * @codeCoverageIgnore
 */
?>
<div ng-controller="Announcements.setting">
	<div class="modal fade"
		id="nc-block-setting-
		<?php echo (int)$frameId; ?>"
		tabindex="-1"
		role="dialog"
		aria-labelledby="myModalLabel"
		aria-hidden="true"
		>
		<div class="modal-dialog nc-modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button
						type="button"
						class="close"
						data-dismiss="modal"
						>
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h3 class="modal-title" id="myModalLabel">
						<?php echo __d('announcements', 'Announcements Plugin'); ?>
						<?php echo __d('announcements', 'Block setting'); ?>
					</h3>
				</div>
				<div class="modal-body">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="active">
							<a href="#nc-announcements-block-setting-update-
								<?php echo (int)$frameId; ?>"
								role="tab"
								data-toggle="tab"
								>
								<?php echo __d('announcements', 'Articles change notification setting'); ?>
							</a>
						</li>
						<li><a href="#nc-announcements-block-setting-request-
								<?php echo (int)$frameId; ?>"
								role="tab"
								data-toggle="ab">
								<?php echo __d('announcements', 'Publication request notification settings'); ?>
							</a>
						</li>
					</ul>
					<!-- end Nav tabs -->

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane"
							id="nc-announcements-block-setting-update-<?php
							echo (int)$frameId; ?>">
							<?php echo $this->element('Announcements.setting/message_update_form'); ?>
						</div>

						<div class="tab-pane"
							id="nc-announcements-block-setting-request-
							<?php echo (int)$frameId; ?>">
							<?php echo $this->element("Announcements.setting/message_publish_form"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="nc-announcements-block-setting-get-edit-form-<?php echo $frameId; ?>"></div>
</div>
