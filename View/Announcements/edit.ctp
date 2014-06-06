<div ng-controller="Announcements.edit">
<div id="announcements_form_view_<?php echo intval($frameId);?>">

	<div class="alert alert-danger hidden">
		<span class="pull-right" ng-click="postAlertClose()"><span class="glyphicon glyphicon-remove"></span></span></span>
		<span class="errorMss">{{alertMss}}</span>
	</div>

<p>
<textarea ui-tinymce
          ng-model="tinymceModel"
          class="form-control html"
></textarea>
</p>

<p class="text-center">
	<button class="btn btn-default" ng-click="post('Cancel', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)"><span class="glyphicon glyphicon-remove"></span> <span><?php echo __('キャンセル'); ?></span></button>
	<button class="btn btn-default" ng-click="post('Draft', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)"><span class="glyphicon glyphicon-pencil"></span> <span><?php echo __('下書き'); ?></span></button>
	<button class="btn btn-primary" ng-click="post('PublishRequest', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)"><span class="glyphicon glyphicon-share-alt"></span> <span><?php echo __('公開申請'); ?></span></button>
	<button class="btn btn-primary" ng-click="post('Publish', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)"><span class="glyphicon glyphicon-share-alt"></span> <span><?php echo __('公開'); ?></span></button>
</p>
</div>

<div id="announcements_post_<?php echo $frameId;?>">---</div>
debug : frameId:<?php echo $frameId;?><br>
debug : blockId:<?php echo $blockId;?>

<pre>{{debug}}</pre>
</div>