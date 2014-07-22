<div class="hidden">
<?php
echo $this->Form->Create(null);
echo $this->Form->input('part_id' , array(
	'type' => 'text',
	'name' => 'data[part_id]',
	'value' => '',
	//'id' => 'announcements_block_setting_flameid_frame_'.$flameId."_parts_".$item['AnnouncementRoomPart']['part_id']
));
echo $this->Form->input('frame_id' , array(
	'type' => 'text',
		'name' => 'data[frame_id]',
		'value' => '',
		//'id' => 'announcements_block_setting_flameid_frame_'.$flameId."_parts_".$item['AnnouncementRoomPart']['part_id']
	));
echo $this->Form->input('block_id' , array(
	'type' => 'text',
		'name' => 'data[block_id]',
		'value' => '',
		//'id' => 'announcements_block_setting_blockid_parts_frame_'.$flameId."_parts_".$item['AnnouncementRoomPart']['part_id']
	));
echo $this->Form->end();
?>
</div>