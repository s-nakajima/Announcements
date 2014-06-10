<div ng-controller="Announcements.edit">

<!-- 編集ボタン 状態表示-->


<div class="text-right">

	<!-- ラベル -->
	<?php echo $this->element("Announcements.lavel"); ?>

	<button class="btn btn-primary"
	        id="announcement_content_edit_btn_<?php echo intval($frameId); ?>"
	        ng-click="getEditer('<?php echo intval($frameId); ?> , <?php echo intval($blockId); ?>')"
	><span>編集</span></button>
	<!-- 公開申請ボタン -->
	<!-- <button
			class="btn btn-danger"
			ng-click="PublishComfirm('<?php echo intval($frameId); ?> , <?php echo intval($blockId); ?>')"
	>
	<span>公開実行</span></button>-->
</div>
<div class="clear:both;"> </div>

	<!-- メッセージ -->
	<p id="announcements_mss_<?php echo intval($frameId);?>">
		<div class="alert alert-danger hidden">
			<span class="pull-right" ng-click="postAlertClose()"><span class="glyphicon glyphicon-remove"></span></span></span>
			<span class="errorMss"></span>
		</div>
	</p>

<!-- プレビュー-->
<div class="preview" id="announcement_content_preview_<?php echo intval($frameId); ?>">
</div>


<!-- 内容表示 -->
<div class="item" id="announcement_content_view_<?php echo intval($frameId); ?>">
<?php if(isset($item)
	&& isset($item['AnnouncementDatum'])
	&& isset($item['AnnouncementDatum']['content'])) {
	$content =  $item['AnnouncementDatum']['content'];
	echo $content;
}?>
</div>

<!-- 非表示 最新 -->

	<div class="draft hidden" id="announcement_content_draft_<?php echo intval($frameId); ?>">
		<?php if(isset($draftItem)
			&& isset($draftItem['AnnouncementDatum'])
			&& isset($draftItem['AnnouncementDatum']['content'])) {
			$draftContent =  $draftItem['AnnouncementDatum']['content'];
			echo $draftContent;
		}?>
	</div>





<!-- 編集枠  -->
<div class="announcements_editer" id="announcements_form_<?php echo intval($frameId);?>">



	<!-- エディタ -->
	<?php echo $this->element("Announcements.index_text_editer"); ?>


	<div class="html-editer">
		<textarea
			id="announcements-html-editer-<?php echo intval($frameId);?>"
			ui-tinymce="tinymceOptions"
			ng-model="tinymceModel"
			class="form-control"
		></textarea></div>

	<!-- ボタン類 -->
	<p class="text-center" style="padding-top: 10px;">
		<button
			class="btn btn-default"
			ng-click="post('Cancel', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)">
			<span class="glyphicon glyphicon-remove"></span>
			<span><?php echo __('閉じる'); ?></span></button>
		<button
			class="btn btn-default"
			id="announcements_btn_preview_<?php echo intval($frameId);?>"
			ng-click="post('Preview', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)">
			<span class="glyphicon glyphicon-file"></span> <span><?php echo __('プレビュー'); ?></span></button>
		<button
			class="btn btn-default hidden"
			id="announcements_btn_preview_close_<?php echo intval($frameId);?>"
			ng-click="post('PreviewClose', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)">
			<span class="glyphicon glyphicon-file"></span> <span><?php echo __('プレビューを閉じる'); ?></span></button>
		<button
			class="btn btn-default"
			ng-click="post('Draft', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)">
			<span class="glyphicon glyphicon-pencil"></span> <span><?php echo __('下書き'); ?></span></button>
		<button
			class="btn btn-primary"
			ng-click="post('PublishRequest', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)">
			<span class="glyphicon glyphicon-share-alt"></span> <span><?php echo __('公開申請'); ?></span></button>
		<button
			class="btn btn-primary"
			ng-click="post('Publish', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)">
			<span class="glyphicon glyphicon-share-alt"></span> <span><?php echo __('公開'); ?></span></button>
	</p>
</div>

	<div id="announcements_post_<?php echo $frameId;?>"></div>
</div>
