<div class="block plugin-announcements block-id-<?php echo $block_id; ?>">
	<?php if ($this->action == 'index' && $block_id > 0): ?>
	<div>
		<?php
			echo $this->Html->link(__d('announcements', 'Edit'), array('action' => 'edit', $block_id));
		?>
	</div>
	<?php endif; ?>
	<?php echo __('Content not found.'); /* TODO: セッティングモードのON、OFFでメッセージを表示するかどうか判断するべき。 */ ?>
</div>