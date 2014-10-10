<div class="announcements form">
<?php echo $this->Form->create('Announcement'); ?>
	<fieldset>
		<legend><?php echo __('Form Announcement'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('block_id');
		echo $this->Form->input('key');
		echo $this->Form->input('status');
		echo $this->Form->input('content');
		echo $this->Form->input('is_auto_translated');
		echo $this->Form->input('translation_engine');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Announcement.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Announcement.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
	</ul>
</div>
