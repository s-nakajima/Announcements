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
	if ($item['Announcement']['status'] == Announcement::STATUS_PUBLISH_REQUEST) {
		$status['publishRequest'] = $show;
	} elseif ($item['Announcement']['status'] == Announcement::STATUS_DRAFT) {
		$status['Draft'] = $show;
	} elseif ($item['Announcement']['status'] == Announcement::STATUS_REJECT) {
		$status['Reject'] = $show;
	} elseif ($item['Announcement']['status'] == Announcement::STATUS_PUBLISH) {
		$status['publish'] = $show;
	}
	$contentStatus = $item['Announcement']['status'];
}
?>
<p ng-init='updateStatus(<?php echo (int) $contentStatus; ?>)'>
	<span
		ng-init='label.publish=<?php echo $status['publish'];?>'
		ng-show='label.publish'
		class='label label-info ng-hide'
		><?php echo __('Published'); ?></span>
	<span
		ng-init='label.draft=<?php echo $status['Draft'];?>'
		ng-show='label.draft'
		class='label label-info ng-hide'
		><?php echo __('Draft'); ?></span>
	<span
		ng-init='label.request=<?php echo $status['publishRequest'];?>'
		ng-show='label.request'
		class='label label-danger ng-hide'
		><?php echo __('Published pending'); ?></span>
	<span
		ng-init='label.reject=<?php echo $status['Reject'];?>'
		ng-show='label.reject'
		class='label label-default ng-hide'
		><?php echo __('Reject in'); ?></span>
	<span class='label label-danger'
	      ng-show='View.edit.preview'
	><?php echo __('Preview'); ?></span>
</p>