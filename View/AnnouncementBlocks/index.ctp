<?php
/**
 * block index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article class="block-setting-body">
	<?php echo $this->Block->mainTabs(BlockTabsComponent::MAIN_TAB_BLOCK_INDEX); ?>

	<div class="tab-content">
		<div class="text-right">
			<?php echo $this->Button->addLink(); ?>
		</div>

		<?php echo $this->NetCommonsForm->create('', array(
				'url' => NetCommonsUrl::actionUrl(array('plugin' => 'frames', 'controller' => 'frames', 'action' => 'edit'))
			)); ?>

			<?php echo $this->Form->hidden('Frame.id'); ?>

			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th>
							<?php echo $this->Paginator->sort('Block.name', __d('announcements', 'Content')); ?>
						</th>
						<th>
							<?php echo $this->Paginator->sort('Announcement.modified', __d('net_commons', 'Updated date')); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($announcements as $announcement) : ?>
						<tr<?php echo ($this->data['Frame']['block_id'] === $announcement['Block']['id'] ? ' class="active"' : ''); ?>>
							<td>
								<?php echo $this->BlockForm->displayFrame('Frame.block_id', $announcement['Block']['id']); ?>
							</td>
							<td>
								<?php echo $this->NetCommonsHtml->editLink($announcement['Block']['name'], array('block_id' => $announcement['Block']['id'])); ?>

								<?php echo $this->Workflow->label($announcement['Announcement']['status']); ?>
							</td>
							<td>
								<?php echo $this->Date->dateFormat($announcement['Announcement']['modified']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php echo $this->Form->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>




