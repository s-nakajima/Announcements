<div id='nc-announcements-<?php echo $frameId; ?>' ng-controller='announcementsController'>
	<?php if ($this->action == 'index' && $blockId > 0): ?>
	<div>
		<?php
			echo $this->element('edit_link');
		?>
	</div>
	<?php endif; ?>
	<?php echo __d('announcements', 'Content not found.'); /* TestCode セッティングモードのON、OFFでメッセージを表示するかどうか判断するべき。セッティングモード未実装につき未実装 */ ?>
	<?php echo $this->element('include'); ?>
</div>
