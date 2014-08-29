<?php
$hidden['draft'] = 'hidden';
$hidden['publishRequest'] = 'hidden';
$hidden['Reject'] = 'hidden';

$status = 0;
//下書き、申請中の状態表示
if (isset($item['Announcement']['status'])) {
	$status = $item['Announcement']['status'];
	if ($status == Announcement::STATUS_DRAFT) {
		$hidden['draft'] = '';
	} elseif ($status == Announcement::STATUS_PUBLISH_REQUEST) {
		$hidden['publishRequest'] = '';
	} elseif ($status == Announcement::STATUS_REJECT) {
		$hidden['Reject'] = '';
	}
}
?>
<p>
	<span class="label label-info <?php
		echo $hidden['draft']; ?>"><?php
		echo __d('announcements', 'Draft'); ?>
	</span>
	<span class="label label-danger <?php
		echo $hidden['publishRequest']; ?>"><?php
		echo __d('announcements', 'Publish Requested'); ?>
	</span>
	<span class="label label-default <?php
	echo $hidden['Reject']; ?>"><?php
		echo __d('announcements', 'Reject'); ?>
	</span>
</p>