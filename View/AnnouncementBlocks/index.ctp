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

App::uses('Topic', 'Topics.Model');
?>

<article class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<?php echo $this->BlockIndex->description(); ?>

	<div class="tab-content">
		<?php echo $this->BlockIndex->create(); ?>
			<?php echo $this->BlockIndex->addLink(); ?>

			<?php echo $this->BlockIndex->startTable(); ?>
				<thead>
					<tr>
						<?php echo $this->BlockIndex->tableHeader(
								'Frame.block_id'
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Block.name', __d('announcements', 'Content'),
								array('sort' => true, 'editUrl' => true)
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
									'Block.public_type', __d('blocks', 'Publishing setting'),
									array('sort' => true)
								); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'TrackableUpdater.handlename', __d('net_commons', 'Modified user'),
								array('sort' => true, 'type' => 'handle')
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Block.modified', __d('net_commons', 'Modified datetime'),
								array('sort' => true, 'type' => 'datetime')
							); ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($announcements as $announcement) : ?>
						<?php echo $this->BlockIndex->startTableRow($announcement['Block']['id']); ?>
							<?php echo $this->BlockIndex->tableData(
									'Frame.block_id', $announcement['Block']['id']
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Block.name',
									'<small>' . $this->Workflow->label($announcement['Announcement']['status']) . '</small>' . ' ' .
									h(mb_strimwidth($announcement['Block']['name'], 0, Topic::DISPLAY_SUMMARY_LENGTH, '...')),
									array('editUrl' => array('block_id' => $announcement['Block']['id']), 'escape' => false)
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Block.public_type', $announcement
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'TrackableUpdater', $announcement,
									array('type' => 'handle')
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Block.modified', $announcement['Block']['modified'],
									array('type' => 'datetime')
								); ?>
						<?php echo $this->BlockIndex->endTableRow(); ?>
					<?php endforeach; ?>
				</tbody>
			<?php echo $this->BlockIndex->endTable(); ?>

		<?php echo $this->BlockIndex->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>
