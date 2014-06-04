<div id="announcements-<?php echo $frameId; ?>" ng-controller="announcementsEditController">
	<?php
		echo $this->Form->create('Announcement', array('ng-submit' => 'submit($event)', 'id' => false, 'class' => 'announcements-edit-outer'));
		$this->Form->unlockField('is_published');
	?>
	<div class="form-group">
		<?php
			$editorId = 'AnnouncementRevisionContent-' . $frameId;
			echo $this->Form->label('AnnouncementRevision.content', __d('announcements', 'Content'), array('for' => $editorId));
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
			echo $this->Form->hidden('is_published', array('id' => 'AnnouncementIsPublished-' . $frameId));
		?>
	</div>
	<div class="text-center">
		<?php
			echo $this->Html->link(__d('announcements', 'Cancel'), array('action' => 'index', $blockId), array('class' => 'cancel btn btn-default', 'ng-click' => 'cancel($event)'));
		?>
		<?php
			echo $this->Form->button(__d('announcements', 'Draft'), array('class' => 'btn btn-default', 'onclick' => "$('#AnnouncementIsPublished-" . $frameId . "').val(0);"));
		?>
		<?php
			echo $this->Form->button(__d('announcements', 'Ok'), array('class' => 'btn btn-primary', 'onclick' => "$('#AnnouncementIsPublished-" . $frameId . "').val(1);"));
		?>
	</div>
	<?php
		echo $this->Form->end();
	?>
	<?php echo $this->element('include'); ?>
</div>
