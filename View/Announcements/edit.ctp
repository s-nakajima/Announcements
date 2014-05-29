<div id="announcements-<?php echo $frame_id; ?>" ng-controller="announcementsEditController">
	<?php
		echo $this->Form->create('Announcement', array('ng-submit' => 'submit($event)', 'id' => false, 'class' => 'announcements-edit-outer'));
		$this->Form->unlockField('is_published');
	?>
	<div class="form-group">
		<?php
			$editorId = 'AnnouncementRevisionContent-' . $frame_id;
			echo $this->Form->label('AnnouncementRevision.content', __d('announcements', 'Content'), array('id' => $editorId));
			echo $this->element('draft_label');
			$this->RichTextEditor->editor(array('elements' => $editorId));
			$settings = array(
				'id' => $editorId,
				'class' => 'hidden',
				'type' => 'textarea',
				'label' => false,
				'required' => false,
			);
			echo $this->Form->input('AnnouncementRevision.content', $settings);
			echo $this->Form->hidden('is_published', array('id' => 'AnnouncementIsPublished-' . $frame_id));
		?>
	</div>
	<div class="text-center">
		<?php
			echo $this->Html->link(__d('announcements', 'Cancel'), array('action' => 'index', $block_id), array('class' => 'cancel btn btn-default', 'ng-click' => 'cancel($event)'));
		?>
		<?php
			echo $this->Form->button(__d('announcements', 'Draft'), array('class' => 'btn btn-default', 'onclick' => "$('#AnnouncementIsPublished-" . $frame_id . "').val(0);"));
		?>
		<?php
			echo $this->Form->button(__d('announcements', 'Ok'), array('class' => 'btn btn-primary', 'onclick' => "$('#AnnouncementIsPublished-" . $frame_id . "').val(1);"));
		?>
	</div>
	<?php
		echo $this->Form->end();
	?>
	<?php echo $this->element('include'); ?>
</div>
