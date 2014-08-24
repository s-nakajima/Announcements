<?php
$roomPartKey = 'LanguagesPart';
?>
	<h3><?php echo __('Editorial control Settings');?> </h3>
	<p class='container'>
		<?php
		foreach ($partList as $key => $item) {
			$partId = $item[$roomPartKey]['part_id'];
			$checked = false;
			if (isset($blockPart[$partId]['edit_content']) && $blockPart[$partId]['edit_content']) {
				$checked = true;
			}
			?><p class='container'><?php
			if (isset($item[$roomPartKey]['edit_content']) && $item[$roomPartKey]['edit_content'] == 1) {
				echo '<span class="glyphicon glyphicon-ok"></span>';
				echo h($item[$roomPartKey]['name']) . '';
			} elseif ( isset($item[$roomPartKey]['edit_content']) && $item[$roomPartKey]['edit_content'] == 0) {
				echo '<span class="glyphicon glyphicon-remove"></span>';
				echo h($item[$roomPartKey]['name']) . '';
			}
			elseif (isset($editVariableArray[$partId]) && $editVariableArray[$partId]) {
				echo $this->Form->input(h($item['LanguagesPart']['name']),
					array(
						'type' => 'checkbox',
						'div' => null,
						'id' => 'nc-announcements-edit-frame-'.$frameId. '-part-' .$item[$roomPartKey]['part_id'],
						'value' => $item[$roomPartKey]['part_id'],
						'name' => 'part_id['. $item[$roomPartKey]['part_id'] .']',
						'checked' => $checked,
						'ng-click' => 'partChange("edit", '.$frameId.','.$item[$roomPartKey]['part_id'].')',
						'autocomplete' => 'off'
					)
				);
			} else {
				?><span class='glyphicon glyphicon-remove'></span><?php
				echo h($item[$roomPartKey]['name']);
			}
			?></p><?php
		}
		?></p>

	<p class='text-center'>
		<button type='button' class='btn btn-default' data-dismiss='modal'><?php echo __('Cancel'); ?></button>
		<button type='button' class='btn btn-primary'
		        ng-click='partSend("editParts",<?php echo (int) $frameId; ?>,<?php echo (int) $blockId; ?>,<?php echo (int) $langId; ?>)'
			>
			<span><?php echo __('Update'); ?></span></button>
	</p>

	<div id='nc-announcements-setting-get-edit-form-<?php echo $frameId; ?>'>

	</div>