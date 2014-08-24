<div id='nc-announcements-data-<?php echo $frameId; ?>'>
<?php echo $this->Form->create(null); ?>
	<div class='hidden'>
		<?php
		echo $this->Form->input('Announcement.content' , array(
				'type' => 'text',
				'value' => '',
			)
		);
		echo $this->Form->input('Announcement.frameId' , array(
				'type' => 'text',
				'value' =>h($frameId),
			)
		);
		echo $this->Form->input('Announcement.blockId' , array(
				'type' => 'text',
				'value' =>h($blockId),
			)
		);
		echo $this->Form->input('Announcement.status' , array(
				'type' => 'text',
				'value' => '',
			)
		);
		echo $this->Form->input('Announcement.langId' , array(
				'type' => 'text',
				'value' => $langId,
			)
		);
		echo $this->Form->input('Announcement.id' , array(
				'type' => 'text',
				'value' => '',
			)
		);
		?>
	</div>
<?php echo $this->Form->end(); ?>
</div>