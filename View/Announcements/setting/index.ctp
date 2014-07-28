<?php
//公開するボタンの非表示
$publishBtnHidden = "hidden";
if( isset($draftItem)
	&& isset($draftItem['AnnouncementDatum'])
	&& (! isset($draftItem['AnnouncementDatum']['status_id']) || $draftItem['AnnouncementDatum']['status_id'] == 2 )
){  $publishBtnHidden  = "";}
?>

<div ng-controller="Announcements.edit">
<!-- 編集ボタン 状態表示-->
<p class="text-right" style="margin-top: 5px;"
   id="announcement-content-edit-btn-<?php echo intval($frameId); ?>"
   ng-hide="View.edit.body"
>
	<!-- block setting-->
	<?php if (isset($isBlockEdit) && $isBlockEdit) { ?>
	<button class="btn btn-default"
		ng-click="openBlockSetting(<?php echo intval($frameId); ?>)"
	><span class="glyphicon glyphicon-cog"> <?php echo __("ブロック設定"); ?></span></button>
	<?php } ?>
	<!-- edit buttun -->
	<?php if($isEdit) { ?>
	<button class="btn btn-primary"
		ng-click="getEditer('<?php echo intval($frameId); ?> , <?php echo intval($blockId); ?>')"
	><span class="glyphicon glyphicon-pencil"> <?php echo __("編集"); ?></span></button>
	<?php } ?>
	<!-- publich button -->
	<?php if($isPublish) { ?>
	<button class="btn btn-danger announcement-btn-publish <?php echo $publishBtnHidden;?>"
		ng-click="post('Publish', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)"
	><span class="glyphicon glyphicon-share-alt"> <?php echo __("公開する"); ?></span></button>
	<?php } ?>
</p>


	<!-- メッセージ -->
	<p>
		<div class="alert alert-danger hidden" id="announcements-mss-<?php echo intval($frameId);?>">
			<span class="pull-right" ng-click="postAlertClose(<?php echo intval($frameId);?>)"><span class="glyphicon glyphicon-remove"> </span></span></span>
			<span class="message"> </span>
		</div>
	</p>

<!-- プレビュー-->
<div class="preview"
     id="announcement-content-preview-<?php echo intval($frameId); ?>"
     ng-show="View.edit.preview"
>
</div>



<!-- 内容表示 -->
<div class="item" id="announcement-content-view-<?php echo intval($frameId); ?>"
	ng-show="View.default"
>
<?php if(isset($item)
	&& isset($item['AnnouncementDatum'])
	&& isset($item['AnnouncementDatum']['content'])) {
	$content =  $item['AnnouncementDatum']['content'];
	echo $content;
}?>
</div>

<!-- 非表示 最新 -->

	<div class="draft hidden" id="announcement-content-draft-<?php echo intval($frameId); ?>">
		<?php if(isset($draftItem)
			&& isset($draftItem['AnnouncementDatum'])
			&& isset($draftItem['AnnouncementDatum']['content'])) {
			$draftContent =  $draftItem['AnnouncementDatum']['content'];
			echo $draftContent;
		}?>
	</div>

<!-- ラベル -->
<?php echo $this->element("Announcements.setting/label"); ?>
<!-- 編集枠  -->
<div class="announcements-editer"
     id="announcements-form-<?php echo intval($frameId);?>"
>

	<!-- エディタ -->


	<div class="html-editer" ng-show="View.edit.html">
		<?php echo $this->element("Announcements.index_text_editer"); ?>
		<textarea
			id="announcements-html-editer-<?php echo intval($frameId);?>"
			ui-tinymce="tinymceOptions"
			ng-model="tinymceModel"
			class="form-control"
		><?php if(isset($draftItem)
			&& isset($draftItem['AnnouncementDatum'])
			&& isset($draftItem['AnnouncementDatum']['content'])) {
			$draftContent =  $draftItem['AnnouncementDatum']['content'];
			echo $draftContent;
		}?></textarea></div>

	<!-- ボタン類 -->
	<?php echo $this->element("Announcements.setting/editer_button");?>
</div>

	<div id="announcements-post-<?php echo $frameId;?>"></div>
	<div id="announcements-block-setting-<?php echo intval($frameId);?>"></div>
</div>

<?php
if($isRoomAdmin) {
	echo $this->element("block_setting/room_admin");
} else {
	echo $this->element("block_setting/editer");
}

?>
