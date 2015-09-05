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
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<div class="text-right">
			<a class="btn btn-success" href="<?php echo $this->Html->url('/announcements/announcement_blocks/add/' . CurrentUtility::read('Frame.id'));?>">
				<span class="glyphicon glyphicon-plus"> </span>
			</a>
		</div>

		<?php echo $this->Form->create('', array('url' => '/frames/frames/edit/' . CurrentUtility::read('Frame.id'))); ?>

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
						<tr<?php echo (CurrentUtility::read('Frame.block_id') === $announcement['Block']['id'] ? ' class="active"' : ''); ?>>
							<td>
								<?php echo $this->NetCommonsForm->radio('Frame.block_id', array($announcement['Block']['id'] => ''), array(
										'onclick' => 'submit()',
										'ng-click' => 'sending=true',
										'ng-disabled' => 'sending'
									)); ?>
							</td>
							<td>
								<a href="<?php echo $this->Html->url(
										'/announcements/announcement_blocks/edit/' . CurrentUtility::read('Frame.id') . '/' . $announcement['Block']['id']); ?>">
									<?php echo h($announcement['Block']['name']); ?>
								</a>

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




