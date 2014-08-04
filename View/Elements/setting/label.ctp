<?php
//セッティングモード時のラベル表示部分
$status_on[1] = 'false';
$status_on[2] = 'false';
$status_on[3] = 'false';
$status_on[4] = 'false';

//下書き、申請中の状態表示
if(isset($draftItem)
	&& isset($draftItem['AnnouncementDatum'])
	&& isset($draftItem['AnnouncementDatum']['status_id'])) {
	$status =  $draftItem['AnnouncementDatum']['status_id'];
	if ($status == 2) {
		$status_on[2] = 'true';
	}
	if ($status == 3) {
		$status_on[3] = 'true';
	}
	if ($status == 4) {
		$status_on[4] = 'true';
	}
}

//公開中表示
if (isset($item)
	&& isset($item['AnnouncementDatum'])
	&& isset($item['AnnouncementDatum']['status_id'])
 	&& $item['AnnouncementDatum']['status_id'] == 1
) {
	$status_on[1] = 'true';
}

?>
<p id="nc-announcement-status-label-<?php echo intval($frameId); ?>">
	<span
		ng-init="label.publish=<?php echo $status_on[1];?>"
		ng-show="label.publish"
		class="label label-info ng-hide"
		><?php echo __('公開中'); ?></span>
	<span
		ng-init="label.draft=<?php echo $status_on[3];?>"
		ng-show="label.draft"
		class="label label-info ng-hide"
		><?php echo __('下書きあり'); ?></span>
	<span
		ng-init="label.request=<?php echo $status_on[2];?>"
		ng-show="label.request"
		class="label label-danger ng-hide"
		><?php echo __('公開申請あり'); ?></span>
	<span
		ng-init="label.reject=<?php echo $status_on[4];?>"
		ng-show="label.reject"
		class="label label-default ng-hide"
		><?php echo __('差し戻しあり'); ?></span>
	<span class="label label-danger"
	      ng-show="View.edit.preview"
	><?php echo __("プレビュー表示中"); ?></span>
</p>