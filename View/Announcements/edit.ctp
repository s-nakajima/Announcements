<?php
// TODO: style指定を後に除去すること。
// TODO:言語ファイルへの切り出しを行っていない。
// $id = 'announcements-'.$frame_id;
?>
<div ng-app="announcements" class="block plugin-announcements block-id-<?php echo $block_id; ?>">
	<?php echo $this->element('edit_block_link'); ?>
	<?php
		echo $this->Form->create('Announcement', array('class' => 'announcements-edit-outer'));
		$this->Form->unlockField('is_published');
	?>
	<div class="form-group">
		<?php
			echo $this->Form->label('AnnouncementRevision.content', __d('announcements', 'Content'));
			echo $this->element('draft_label');
			$this->RichTextEditor->editor(array('elements' => 'AnnouncementRevisionContent'));
			$settings = array(
				'class' => 'hidden',
				'type' => 'textarea',
				'label' => false
			);
			echo $this->Form->input('AnnouncementRevision.content', $settings);
			echo $this->Form->hidden('AnnouncementRevision.id');
			echo $this->Form->hidden('id');
			echo $this->Form->hidden('block_id', array('value' => $block_id));
			echo $this->Form->hidden('is_published');
		?>
	</div>
	<div class="text-center">
		<?php
			echo $this->Html->link(__d('announcements', 'Cancel'), array('action' => 'index', $block_id), array('class' => 'cancel btn btn-default'));
		?>
		<?php
			echo $this->Form->button(__d('announcements', 'Draft'), array('class' => 'btn btn-default', 'onclick' => "$('#AnnouncementIsPublished').val(0);"));
		?>
		<?php
			echo $this->Form->button(__d('announcements', 'Ok'), array('class' => 'btn btn-primary', 'onclick' => "$('#AnnouncementIsPublished').val(1);"));
		?>
	</div>
	<?php
		echo $this->Form->end();
	?>
</div>
