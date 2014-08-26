<p class='text-right'
	id='nc-announcement-content-edit-btn-<?php echo (int)$frameId; ?>'
	ng-hide='View.edit.body'
>

	<?php if (isset($blockEditable) && $blockEditable) { ?>
		<button class='btn btn-default'
			ng-click='openBlockSetting(<?php echo (int)$frameId; ?>)'
			ng-disabled='sendLock'
		><span class='glyphicon glyphicon-cog'> <?php echo __('Block setting'); ?></span></button>
	<?php } ?>

	<?php if ($contentEditable) { ?>
		<button class='btn btn-primary'
			ng-click='getEditor(<?php echo (int)$frameId; ?>)'
			ng-disabled='sendLock'
			><span class='glyphicon glyphicon-pencil'> <?php echo __('Edit'); ?></span></button>
	<?php } ?>

	<?php if ($contentPublishable) { ?>
		<button class='btn btn-danger ng-hide'
			ng-show='label.request'
			ng-click='post("Publish", <?php echo (int)$frameId; ?>)'
			ng-disabled='sendLock'
			><span class='glyphicon glyphicon-share-alt'> <?php echo __('Publish'); ?></span></button>
	<?php } ?>
</p>
