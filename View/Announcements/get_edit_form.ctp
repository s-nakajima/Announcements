<div id="announcements_data_<?php echo $frameId?>">
<?php echo $this->Form->create(null); ?>
	<div style="display: none;">
		<?php
		echo $this->Form->input("AnnouncementDatum.content" , array(
				"type" => "text",
				"value" =>"",
			)
		);
		echo $this->Form->input("AnnouncementDatum.frameId" , array(
				"type" => "text",
				"value" =>h($frameId),
			)
		);
		echo $this->Form->input("AnnouncementDatum.blockId" , array(
				"type" => "text",
				"value" =>h($blockId),
			)
		);
		echo $this->Form->input("AnnouncementDatum.type" , array(
				"type" => "text",
				"value" =>"",
			)
		);
		echo $this->Form->input("AnnouncementDatum.lang" , array(
				"type" => "text",
				"value" =>$lang,
			)
		); ?>
		?>

		?>


	</div>
<?php echo $this->Form->end(); ?>
</div>