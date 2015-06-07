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

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<div class="text-right">
			<a class="btn btn-success" href="<?php echo $this->Html->url('/announcements/announcement_blocks/add/' . $frameId);?>">
				<span class="glyphicon glyphicon-plus"> </span>
			</a>
		</div>

		<div id="nc-announcements-setting-<?php echo $frameId; ?>">
			<?php echo $this->Form->create('', array(
					'url' => '/frames/frames/edit/' . $frameId
				)); ?>

				<?php echo $this->Form->hidden('Frame.id', array(
						'value' => $frameId,
					)); ?>

				<table class="table table-hover">
					<thead>
						<tr>
							<th></th>
							<th>
								<?php echo __d('announcements', 'Content'); ?>
							</th>
							<th>
								<?php echo $this->Paginator->sort('Block.public_type', __d('blocks', 'Publishing setting')); ?>
							</th>
							<th>
								<?php echo $this->Paginator->sort('Edumap.modified', __d('net_commons', 'Updated date')); ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($announcements as $announcement) : ?>
							<tr<?php echo ($blockId === $announcement['block']['id'] ? ' class="active"' : ''); ?>>
								<td>
									<?php echo $this->Form->input('Frame.block_id',
										array(
											'type' => 'radio',
											'name' => 'data[Frame][block_id]',
											'options' => array((int)$announcement['block']['id'] => ''),
											'div' => false,
											'legend' => false,
											'label' => false,
											'hiddenField' => false,
											'checked' => (int)$announcement['block']['id'] === (int)$blockId,
											'onclick' => 'submit()',
											'ng-click' => 'sending=true',
											'ng-disabled' => 'sending'
										)); ?>
								</td>
								<td>
									<a href="<?php echo $this->Html->url('/announcements/announcement_blocks/edit/' . $frameId . '/' . (int)$announcement['block']['id']); ?>">
										<?php echo String::truncate(strip_tags($announcement['announcement']['content']), Announcement::LIST_TITLE_LENGTH); ?>
									</a>
								</td>
								<td>
									<?php if ($announcement['block']['publicType'] === '0') : ?>
										<?php echo __d('blocks', 'Private'); ?>
									<?php elseif ($announcement['block']['publicType'] === '1') : ?>
										<?php echo __d('blocks', 'Public'); ?>
									<?php elseif ($announcement['block']['publicType'] === '2') : ?>
										<?php echo __d('blocks', 'Limited'); ?>
									<?php endif; ?>
								</td>
								<td>
									<?php echo $this->Date->dateFormat($announcement['announcement']['modified']); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo $this->Form->end(); ?>

			<div class="text-center">
				<?php echo $this->element('NetCommons.paginator', array(
						'url' => Hash::merge(
							array('controller' => 'announcement_blocks', 'action' => 'index', $frameId),
							$this->Paginator->params['named']
						)
					)); ?>
			</div>
		</div>
	</div>
</div>




