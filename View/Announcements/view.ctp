<div class="announcements view">
<h2><?php echo __('Announcement'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Block'); ?></dt>
		<dd>
			<?php echo $this->Html->link($announcement['Block']['name'], array('controller' => 'blocks', 'action' => 'view', $announcement['Block']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Key'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Auto Translated'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['is_auto_translated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Translation Engine'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['translation_engine']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created User'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['created_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified User'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['modified_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Announcement'), array('action' => 'edit', $announcement['Announcement']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Announcement'), array('action' => 'delete', $announcement['Announcement']['id']), null, __('Are you sure you want to delete # %s?', $announcement['Announcement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
	</ul>
</div>
