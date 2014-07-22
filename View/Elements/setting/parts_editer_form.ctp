
	<h3>編集権限管理</h3>
	<p class="container">
		<?php

		foreach ($partList as $key=>$item) {

			echo '<p class="container">';
			if ($item['AnnouncementRoomPart']['edit_content'] == 1) {
				echo '<span class="glyphicon glyphicon-ok"></span>';
				echo h($item["LanguagesPart"]['name']) . "";
			} elseif ($item['AnnouncementRoomPart']['edit_content'] == 0) {
				echo '<span class="glyphicon glyphicon-remove"></span>';
				echo h($item["LanguagesPart"]['name']) . "";
			}
			elseif ($item['AnnouncementRoomPart']['edit_content'] == 2) {
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
			}
			echo '</p>';
		}
		?></p>

	<p class="text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("キャンセル"); ?></button>
		<button type="button" class="btn btn-primary"
		        ng-click="partSend('editParts',<?php echo $frameId; ?>,<?php echo $blockId; ?>,<?php echo $langId; ?>)"
			>
			<span><?php echo __("更新する"); ?></span></button>
	</p>

	<div id="announcements_setting_get_edit_form_<?php echo $frameId; ?>">

	</div>

<!-- -->