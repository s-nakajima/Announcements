<div class='hidden'>
	<?php
		echo $this->Form->Create(null);

		echo $this->Form->input('part_id', array(
			'type' => 'text',
			'name' => 'data[part_id]',
			'value' => '',
		));

		echo $this->Form->input('frame_id', array(
			'type' => 'text',
			'name' => 'data[frame_id]',
			'value' => ''
		));

		echo $this->Form->input('block_id', array(
			'type' => 'text',
			'name' => 'data[block_id]',
			'value' => '',
		));

		echo $this->Form->end();
	?>
</div>