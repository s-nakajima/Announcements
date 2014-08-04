<?php
$status_hidden[2] = "hidden";
$status_hidden[3] = "hidden";


//下書き、申請中の状態表示
if(isset($item)
	&& isset($item['AnnouncementDatum'])
	&& isset($item['AnnouncementDatum']['status_id'])) {
	$status = $item['AnnouncementDatum']['status_id'];
	if($status == 2){
		$status_hidden[2] = "";
	}
	if($status == 3){
		$status_hidden[3] = "";
	}
}
?>
<p id="nc-announcement-status-label_<?php echo intval($frameId); ?>">
	<span class="label label-info <?php echo $status_hidden[3]; ?>"><?php echo __("下書き中"); ?></span>
	<span class="label label-danger <?php echo $status_hidden[2]; ?>"><?php echo __("公開申請中"); ?></span>
</p>