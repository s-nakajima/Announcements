<?php
$status_hidden[1] = "hidden";
$status_hidden[2] = "hidden";
$status_hidden[3] = "hidden";

//下書き、申請中の状態表示
if(isset($draftItem)
	&& isset($draftItem['AnnouncementDatum'])
	&& isset($draftItem['AnnouncementDatum']['status_id'])) {
	$status =  $draftItem['AnnouncementDatum']['status_id'];
	if($status == 2){
		$status_hidden[2] = "";
	}
	if($status == 3){
		$status_hidden[3] = "";
	}
}

//公開中表示
if(isset($item)
	&& isset($item['AnnouncementDatum'])
	&& isset($item['AnnouncementDatum']['content'])) {
	$status_hidden[1] = "";
}

?>
<p id="announcement_status_label_<?php echo intval($frameId); ?>">
	<span class="label label-info announcement-status-1   <?php echo $status_hidden[1]; ?>">公開中</span>
	<span class="label label-info announcement-status-3   <?php echo $status_hidden[3]; ?>">下書きあり</span>
	<span class="label label-danger announcement-status-2 <?php echo $status_hidden[2]; ?>">公開申請あり</span>
	<span class="label label-danger announcement-preview hidden"><?php echo __("プレビュー表示中"); ?></span>
</p>