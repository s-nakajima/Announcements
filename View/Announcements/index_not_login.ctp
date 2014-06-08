<!-- 内容表示 -->
<div class="item" id="announcement_content_view_<?php echo intval($frameId); ?>">
<?php if(isset($item)
	&& isset($item['AnnouncementDatum'])
	&& isset($item['AnnouncementDatum']['content'])) {
	$content =  $item['AnnouncementDatum']['content'];
	echo $content;
}?>
</div>