<?php
// セッティングモード エディタ用ボタン
//表示非表示初期値制御
$hidden['draft'] = "";
$hidden['preview']= "";
$hidden['previewCLose']= "hidden";
$hidden['draft']= "";
$hidden['reject'] = "";
$hidden['publish'] = "";

if ($draftItem
	&& isset($draftItem['AnnouncementDatum'])
	&& isset($draftItem['AnnouncementDatum']['status_id'])
	&& $draftItem['AnnouncementDatum']['status_id'] == 2) {
	$hidden['draft']= ' hidden';
	$hidden['reject'] = '';
} else {
	$hidden['draft']= '';
	$hidden['reject'] = ' hidden';
}

?>
<p class="text-center"
   id="announcement-editer-button-<?php echo intval($frameId); ?>"
	style="padding-top: 10px;"
>
	<button
		class="btn btn-default announcement-editer-button-close "
		ng-click="closeForm(<?php echo intval($frameId);?>)">
		<span class="glyphicon glyphicon-remove"></span>
		<span><?php echo __('閉じる'); ?></span></button>
	<button
		class="btn btn-default announcement-editer-button-preview "
		id="announcements-btn-preview-<?php echo intval($frameId);?>"
		ng-click="showPreview(<?php echo intval($frameId);?>)">
		<span class="glyphicon glyphicon-file"></span> <span><?php echo __('プレビュー'); ?></span></button>
	<button
		class="btn btn-default <?php echo $hidden['previewCLose']; ?> announcement-editer-button-preview-close"
		ng-click="closePreview(<?php echo intval($frameId);?>)">
		<span class="glyphicon glyphicon-file"></span> <span><?php echo __('プレビューを閉じる'); ?></span></button>
	<button
		class="btn btn-default announcement-editer-button-draft <?php echo $hidden['draft']; ?>"
		ng-click="post('Draft', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)">
		<span class="glyphicon glyphicon-pencil"></span> <span><?php echo __('下書き'); ?></span></button>
	<button
		class="btn btn-default announcement-editer-button-reject <?php echo $hidden['reject']; ?>"
		ng-click="post('Reject', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)">
		<span class="glyphicon glyphicon-pencil"></span> <span><?php echo __('差し戻し'); ?></span></button>
	<button
		class="btn btn-primary announcement-editer-button-request"
		ng-click="post('PublishRequest', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)"
		>
		<span class="glyphicon glyphicon-share-alt"></span> <span><?php echo __('公開申請'); ?></span></button>
	<button
		class="btn btn-primary announcement-editer-button-publish"
		ng-click="post('Publish', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)">
		<span class="glyphicon glyphicon-share-alt"></span> <span><?php echo __('公開'); ?></span></button>
</p>