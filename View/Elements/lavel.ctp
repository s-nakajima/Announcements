<?php
$status_hidden[1] = "hidden";
$status_hidden[2] = "hidden";
$status_hidden[3] = "hidden";

if(isset($draftItem)
	&& isset($draftItem['AnnouncementDatum'])
	&& isset($draftItem['AnnouncementDatum']['status_id'])) {
	$status =  $draftItem['AnnouncementDatum']['status_id'];

	if($status == 1){
		$status_hidden[1] = "";
	}
	elseif($status == 2){
		$status_hidden[2] = "";
	}
	elseif($status == 3){
		$status_hidden[3] = "";
	}
}?>
<p id="announcement_status_label_<?php echo intval($frameId); ?>">
	<span class="label label-info announcement-status-1   <?php echo $status_hidden[1]; ?>">公開中</span><br>
	<span class="label label-info announcement-status-3   <?php echo $status_hidden[3]; ?>">下書きあり</span>
	<span class="label label-danger announcement-status-2 <?php echo $status_hidden[2]; ?>">公開申請中データあり</span>
</p>