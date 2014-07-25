
	<h3><?php echo __("公開権限設定"); ?></h3>
	<p class="container">
		<?php

		foreach($partList as $key=>$item){
			echo '<p class="container">';
			if ($item['AnnouncementRoomPart']['publish_content'] == 1) {
				echo '<span class="glyphicon glyphicon-ok"></span>';
				echo h($item["LanguagesPart"]['name']) . "";
			} elseif ($item['AnnouncementRoomPart']['publish_content'] == 0) {
				echo '<span class="glyphicon glyphicon-remove"></span>';
				echo h($item["LanguagesPart"]['name']) . "";
			}
			elseif ($item['AnnouncementRoomPart']['publish_content'] == 2) {
				echo $this->Form->input(h($item["LanguagesPart"]['name']),
					array(
						'type' => 'checkbox',
						'div' => null,
						'id' => 'announcements_publish_frame_'.$frameId. "_part_" .$item['AnnouncementRoomPart']['part_id'],
						'value' => $item['AnnouncementRoomPart']['part_id'],
						'name' => 'part_id['. $item['AnnouncementRoomPart']['part_id'] .']',
						//'ng-change'=>'partChange("publish", '.$frameId.','.$item['AnnouncementRoomPart']['part_id'].')',
						'ng-click'=>'partChange("publish", '.$frameId.','.$item['AnnouncementRoomPart']['part_id'].')',
					)
				);
			}
			echo '</p>';
		}
		?></p>
	<div id="send_1_<?php echo $frameId; ?>" style="display: none" class="alert alert-warning text-center" style="height:25px;" role="alert">
		保存中
	</div>



	<p class="text-center" id="send_<?php echo $frameId; ?>" style="height:25px;">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("キャンセル"); ?></button>
		<button type="button" class="btn btn-primary"
			ng-click="partSend('publishParts',<?php echo intval($frameId); ?>,<?php echo intval($blockId); ?>,<?php echo intval($langId); ?>)"
			><span><?php echo __("更新する"); ?></span></button>
	</p>


	<div id="send_2_<?php echo $frameId; ?>" style="display: none"  class="alert alert-success text-center" role="alert" style="height:25px;">
		保存しました
	</div>

<!-- -->