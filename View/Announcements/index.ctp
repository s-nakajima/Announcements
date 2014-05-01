<?php echo $this->element('edit_block_link'); ?>
<div class="block plugin-announcements block-id-<?php echo $block_id; ?>">
	<div>
		<?php
			echo $this->Html->link(__d('announcements', 'Edit'), array('action' => 'edit', $block_id));
			echo $this->element('draft_label');
		?>
	</div>
	<?php echo $this->data['AnnouncementRevision']['content']; ?>
</div>