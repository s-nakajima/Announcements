<?php
$roomPartKey = 'NetCommonsRoomPart';
?>
	<h3><?php echo __("編集権限設定");?> </h3>
	<p class="container">
		<?php
		foreach ($partList as $key=>$item) {
			$partId = $item[$roomPartKey]['part_id'];
			$checked = false;
			if ($blockPart[$partId]["edit_content"]) {
				$checked = true;
			}
			echo '<p class="container">';
			if ($item[$roomPartKey]['edit_content'] == 1) {
				echo '<span class="glyphicon glyphicon-ok"></span>';
				echo h($item["LanguagesPart"]['name']) . "";
			} elseif ($item[$roomPartKey]['edit_content'] == 0) {
				echo '<span class="glyphicon glyphicon-remove"></span>';
				echo h($item["LanguagesPart"]['name']) . "";
			}
			elseif (isset($editVariableArray[$partId]) && $editVariableArray[$partId]) {
				echo $this->Form->input(h($item["LanguagesPart"]['name']),
					array(
						'type' => 'checkbox',
						'div' => null,
						'id' => 'nc-announcements-edit-frame-'.$frameId. "-part-" .$item[$roomPartKey]['part_id'],
						'value' => $item[$roomPartKey]['part_id'],
						'name' => 'part_id['. $item[$roomPartKey]['part_id'] .']',
						'checked' => $checked,
						'ng-click'=>'partChange("edit", '.$frameId.','.$item[$roomPartKey]['part_id'].')',
						'autocomplete'=>'off'
					)
				);
			} else {
				echo '<span class="glyphicon glyphicon-remove"></span>';
				echo h($item["LanguagesPart"]['name']) . "";
			}
			echo '</p>';
		}
		?></p>

	<p class="text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("キャンセル"); ?></button>
		<button type="button" class="btn btn-primary"
		        ng-click="partSend('editParts',<?php echo intval($frameId); ?>,<?php echo intval($blockId); ?>,<?php echo intval($langId); ?>)"
			>
			<span><?php echo __("更新する"); ?></span></button>
	</p>

	<div id="nc-announcements-setting-get-edit-form-<?php echo intval($frameId); ?>">

	</div>

<!-- -->