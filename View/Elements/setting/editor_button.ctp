<?php
// セッティングモード エディタ用ボタン
//表示非表示初期値制御
$hidden['draft'] = '';
$hidden['preview'] = '';
$hidden['previewCLose'] = 'hidden';
$hidden['draft'] = '';
$hidden['reject'] = '';
$hidden['publish'] = '';

if (isset($item['Announcement']['status_id'])
	&& $item['Announcement']['status'] === Announcement::STATUS_REJECT) {
	$hidden['draft'] = ' hidden';
	$hidden['reject'] = '';
} else {
	$hidden['draft'] = '';
	$hidden['reject'] = ' hidden';
}

?>
<br>
<p class="text-center" id="nc-announcement-editor-button-<?php echo (int)$frameId; ?>">
	<button
		class="btn btn-default announcement-editor-button-close"
		ng-disabled="DisabledPost"
		ng-click="closeForm(<?php echo (int)$frameId; ?>)">
		<span class="glyphicon glyphicon-remove"></span>
		<span><?php echo __('Close'); ?></span></button>
	<button
		class="btn btn-default announcement-editor-button-preview "
		id="nc-announcements-btn-preview-<?php echo (int)$frameId; ?>"
		ng-click="showPreview(<?php echo (int)$frameId; ?>)"
		ng-hide="View.edit.preview"
		ng-disabled="DisabledPost"
		>
		<span class="glyphicon glyphicon-file"></span> <span><?php echo __('Preview'); ?></span></button>
	<button
		class="btn btn-default announcement-editor-button-preview-close"
		ng-click="closePreview(<?php echo (int)$frameId; ?>)"
		ng-show="View.edit.preview"
		ng-disabled="DisabledPost"
		>
		<span class="glyphicon glyphicon-file"></span> <span><?php echo __('Close Preview'); ?></span></button>
	<button
		class="btn btn-default"
		ng-click="post('Draft', <?php echo (int)$frameId; ?>)"
		ng-hide="label.request"
		ng-disabled="DisabledPost"
	>
		<span class="glyphicon glyphicon-pencil"></span> <span><?php echo __('Draft'); ?></span></button>

	<button
		class="btn btn-default"
		ng-click="post('Reject', <?php echo (int)$frameId; ?>)"
		ng-show="label.request"
		ng-disabled="DisabledPost"
		>
		<span class="glyphicon glyphicon-pencil"></span> <span><?php echo __('Reject'); ?></span>
	</button>
	<?php if (! $contentEditable) { ?>
	<button
		class="btn btn-primary announcement-editor-button-request"
		ng-click="post("PublishRequest", <?php echo $frameId; ?>)"
		ng-disabled="DisabledPost"
		>
		<span class="glyphicon glyphicon-share-alt"></span> <span><?php echo __('Publish Request'); ?></span></button>
	<?php } ?>
	<button
		class="btn btn-primary announcement-editor-button-publish"
		ng-click="post('Publish', <?php echo $frameId; ?>)"
		ng-disabled="DisabledPost"
	>
		<span class="glyphicon glyphicon-share-alt"></span> <span><?php echo __('Publish'); ?></span></button>
</p>