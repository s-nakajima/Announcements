<?php
$roomPartKey = 'LanguagesPart';
?>
	<h3><?php echo __('Publication control Settings'); ?></h3>
	<p class='container'>
		<?php
		foreach ($partList as $key => $item) {
			$partId = $item[$roomPartKey]['part_id'];
			echo '<p class="container">';
			if ($item[$roomPartKey]['publish_content'] == 1) {
				echo '<span class="glyphicon glyphicon-ok"></span>';
				echo h($item['LanguagesPart']['name']);
			} elseif ($item[$roomPartKey]['publish_content'] == 0) {
				echo '<span class="glyphicon glyphicon-remove"></span>';
				echo h($item['LanguagesPart']['name']);
			}
			elseif (isset($publishVariableArray[$partId]) && $publishVariableArray[$partId]) {
				$checked = false;
				if ($blockPart[$partId]['publish_content']) {
					$checked = true;
				}
				echo $this->Form->input(h($item['LanguagesPart']['name']),
					array(
						'type' => 'checkbox',
						'div' => null,
						'id' => 'nc-announcements-publish-frame-' . $frameId. '-part-' . $item[$roomPartKey]['part_id'],
						'value' => $item[$roomPartKey]['part_id'],
						'name' => 'part_id[' . $item[$roomPartKey]['part_id'] . ']',
						'checked' => $checked,
						'ng-click' => 'partChange("publish", ' . $frameId . ',' . $item[$roomPartKey]['part_id'] . ')',
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
	<div id='send_1_<?php echo (int) $frameId; ?>' class='alert alert-warning text-center ng-hidden'  role='alert'>
		保存中
	</div>



	<p class='text-center' id='send_<?php echo $frameId; ?>'>
		<button type='button' class='btn btn-default' data-dismiss='modal'><?php echo __('Cancel'); ?></button>
		<button type='button' class='btn btn-primary'
			ng-click='partSend('publishParts',<?php echo (int) $frameId; ?>,<?php echo (int) $blockId; ?>,<?php echo (int) $langId; ?>)'
			><span><?php echo __('Update'); ?></span></button>
	</p>


	<div id='send_2_<?php echo $frameId; ?>' class='alert alert-success text-center ng-hidden' role='alert'>
		<?php echo __('Saved');?>
	</div>
?>