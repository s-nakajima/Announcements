<?php echo $this->element('include'); ?>
<div id="announcements-<?php echo $frameId; ?>" ng-controller="announcementsController">
	<div>
		<?php
		echo $this->element('edit_link');
		echo $this->element('draft_label');
		?>
	</div>
	<?php echo $this->data['AnnouncementRevision']['content']; ?>

</div>
