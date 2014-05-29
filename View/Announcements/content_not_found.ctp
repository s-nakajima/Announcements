<div id="announcements-<?php echo $frame_id; ?>" ng-controller="announcementsController">
	<?php if ($this->action == 'index' && $block_id > 0): ?>
	<div>
		<?php
			echo $this->element('edit_link');
		?>
	</div>
	<?php endif; ?>
	<?php echo __('Content not found.'); /* TODO: セッティングモードのON、OFFでメッセージを表示するかどうか判断するべき。セッティングモード未実装につき未実装 */ ?>
	<?php echo $this->element('include'); ?>
</div>
