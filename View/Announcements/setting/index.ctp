<div id="nc-announcements-<?php echo (int)$frameId; ?>" ng-controller="Announcements.edit" ng-init='setInit(<?php echo $frameId; ?>,<?php echo (int)$blockId; ?>,<?php echo (int)$langId; ?>)' >
	<?php echo $this->element('setting/top_menu'); ?>
	<div class='alert alert-danger hidden' id='nc-announcements-mss-<?php echo (int)$frameId; ?>'>
		<span class='pull-right' ng-click='postAlertClose(
		<?php echo (int)$frameId; ?>
		)'><span class='glyphicon glyphicon-remove'> </span></span></span>
		<span class='message'> </span>
	</div>

	<div class="item" id="nc-announcement-content-view-<?php echo (int)$frameId; ?>"
		ng-init="View.default=true"
		ng-show="View.default">
		<?php if (isset($item['Announcement']['content'])) {
			echo $item['Announcement']['content'];
		}
		?>
	</div>

	<?php echo $this->element('setting/preview'); ?>

	<div class='draft hidden' id='nc-announcement-content-draft-<?php echo (int)$frameId; ?>'>
		<?php if (isset($item['Announcement']['content'])) {
			echo $item['Announcement']['content'];
		} ?>
	</div>

	<?php echo $this->element('setting/label'); ?>

	<div id='nc-announcements-form-<?php echo (int)$frameId; ?>'
		ng-init='View.edit.body=false'
		ng-show='View.edit.body'
		class='ng-hide'>

		<div class="html-editor" ng-show="View.edit.html">
			<ul class="nav nav-tabs" role="tablist">
				<li>
					<span class="btn btn-default" ng-click="openTextEditor(<?php echo (int)$frameId; ?>)">
						<?php echo __('HTML'); ?>
					</span>
				</li>
			</ul>
			<textarea
				id="nc-announcements-html-editor-<?php echo (int) $frameId; ?>"
				ui-tinymce="tinymceOptions"
				ng-model="tinymceModel"
				class="form-control">
				<?php
				if (isset($item['Announcement']['content'])) {
					echo $item['Announcement']['content'];
				}?></textarea>
		</div>

		<div ng-show="View.edit.text">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active">
					<span class="btn btn-default"
						ng-click="closeTextEditor(<?php echo (int)$frameId; ?>)"
						><?php echo __('HTML'); ?>
					</span></li>
			</ul>
			<textarea
				class="form-control"
				ng-model="textEditorModel"
				rows="7"
				>{{textEditorModel}}</textarea>
		</div>


		<?php echo $this->element('Announcements.setting/editor_button');?>
	</div>

	<div id='nc-announcements-post-<?php echo (int)$frameId; ?>'></div>
	<div id='nc-announcements-block-setting-<?php echo (int)$frameId; ?>'></div>


</div>
<?php
//block setting
if ($isRoomAdmin) {
	echo $this->element('block_setting/room_admin');
} else {
	echo $this->element('block_setting/editor');
}

