
	<h3><?php echo __("編集権限設定");?> </h3>
	<p class="container">
		<?php

		foreach ($partList as $key=>$item) {
			$partId = $item['AnnouncementRoomPart']['part_id'];
			echo '<p class="container">';
			if ($item['AnnouncementRoomPart']['edit_content'] == 1) {
				echo '<span class="glyphicon glyphicon-ok"></span>';
				echo h($item["LanguagesPart"]['name']) . "";
			} elseif ($item['AnnouncementRoomPart']['edit_content'] == 0) {
				echo '<span class="glyphicon glyphicon-remove"></span>';
				echo h($item["LanguagesPart"]['name']) . "";
			}
			elseif (isset($editVariableArray[$partId]) && $editVariableArray[$partId]) {
				echo $this->Form->input(h($item["LanguagesPart"]['name']),
					array(
						'type' => 'checkbox',
						'div' => null,
						'id' => 'announcements_edit_frame_'.$frameId. "_part_" .$item['AnnouncementRoomPart']['part_id'],
						'value' => $item['AnnouncementRoomPart']['part_id'],
						'name' => 'part_id['. $item['AnnouncementRoomPart']['part_id'] .']',
						//'ng-change'=>'partChange("edit", '.$frameId.','.$item['AnnouncementRoomPart']['part_id'].')',
						'ng-click'=>'partChange("edit", '.$frameId.','.$item['AnnouncementRoomPart']['part_id'].')',
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

	<div id="announcements_setting_get_edit_form_<?php echo intval($frameId); ?>">

	</div>

<!-- -->