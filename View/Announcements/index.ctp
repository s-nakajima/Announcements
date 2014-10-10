<div class="announcements index">
	<h2><?php echo __('Announcements'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('block_id'); ?></th>
			<th><?php echo $this->Paginator->sort('key'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('content'); ?></th>
			<th><?php echo $this->Paginator->sort('is_auto_translated'); ?></th>
			<th><?php echo $this->Paginator->sort('translation_engine'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($announcements as $announcement): ?>
	<tr>
		<td><?php echo h($announcement['Announcement']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($announcement['Block']['name'], array('controller' => 'blocks', 'action' => 'view', $announcement['Block']['id'])); ?>
		</td>
		<td><?php echo h($announcement['Announcement']['key']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['status']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['content']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['is_auto_translated']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['translation_engine']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['created_user']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['created']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['modified_user']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $announcement['Announcement']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $announcement['Announcement']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $announcement['Announcement']['id']), null, __('Are you sure you want to delete # %s?', $announcement['Announcement']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Announcement'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
	</ul>
</div>
