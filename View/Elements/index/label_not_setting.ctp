<?php
$hidden['publish'] = 'hidden';
$hidden['publishRequest'] = 'hidden';

$status = 0;
//下書き、申請中の状態表示
if (isset($item['Announcement']['status'])) {
	$status = $item['Announcement']['status'];
	if ($status == Announcement::STATUS_PUBLISH) {
		$hidden['publish'] = '';
	}
	if ($status == Announcement::STATUS_PUBLISH_REQUEST) {
		$hidden['publishRequest'] = '';
	}
}
?>
<p>
	<span class='label label-info <?php echo $hidden['publishRequest']; ?>'><?php echo __('Draft'); ?></span>
	<span class='label label-danger <?php echo $hidden['publish']; ?>'><?php echo __('Publish Requested'); ?></span>
</p>