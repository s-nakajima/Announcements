<?php
//セッティングモード時のラベル表示部分
//下書き、申請中の状態表示
$show = 'true';
$hidden = 'false';
$status['publish'] = $hidden;
$status['publishRequest'] = $hidden;
$status['Draft'] = $hidden;
$status['Reject'] = $hidden;
$contentStatus = 0;

if (isset($item['Announcement']['status'])) {
	if ((int)$item['Announcement']['status'] === Announcement::STATUS_PUBLISH_REQUEST) {
		$status['publishRequest'] = $show;
	} elseif ((int)$item['Announcement']['status'] === Announcement::STATUS_DRAFT) {
		$status['Draft'] = $show;
	} elseif ((int)$item['Announcement']['status'] === Announcement::STATUS_REJECT) {
		$status['Reject'] = $show;
	} elseif ((int)$item['Announcement']['status'] === Announcement::STATUS_PUBLISH) {
		$status['publish'] = $show;
	}
	$contentStatus = $item['Announcement']['status'];
}
?>
<p ng-init="updateStatus(<?php echo (int)$contentStatus; ?>)">
	<span
		class="label label-info"
		ng-init="label.publish='<?php echo $status['publish'];?>'"
		ng-show="label.publish"
		><?php echo __d('announcements', 'Published'); ?></span>
	<span
		class="label label-info"
		ng-init="label.draft=<?php echo $status['Draft'];?>"
		ng-show="label.draft"
		><?php echo __d('announcements', 'Draft'); ?></span>
	<span
		class="label label-danger ng-hide"
		ng-init="label.request=<?php echo $status['publishRequest'];?>"
		ng-show="label.request"
		><?php echo __d('announcements', 'Waiting Publish'); ?></span>
	<span
		class="label label-default ng-hide"
		ng-init="label.reject=<?php echo $status['Reject'];?>"
		ng-show="label.reject"
		><?php echo __d('announcements', 'Reject in'); ?></span>
	<span class="label label-danger ng-hide"
	      ng-show="View.edit.preview"
	><?php echo __d('announcements', 'Preview'); ?></span>
</p>