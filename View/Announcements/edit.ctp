<script>
	tinyMCE.init({
		language: "ja"
	});
</script>
<div ng-controller="Announcements.edit">

<p>
<textarea ui-tinymce
          ng-model="tinymceModel"
          class="form-control"
></textarea>

	<pre>{{tinymceModel}}</pre>
	<pre>{{debug}}</pre>
</p>
<p class="text-center">
	<button class="btn btn-default" ng-click="post('Cancel', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)"><span class="glyphicon glyphicon-remove"></span> <span><?php echo __('キャンセル'); ?></span></button>
	<button class="btn btn-default" ng-click="post('Draft', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)"><span class="glyphicon glyphicon-pencil"></span> <span><?php echo __('下書き'); ?></span></button>
	<button class="btn btn-primary" ng-click="post('Publish', <?php echo intval($frameId);?> , <?php echo intval($blockId);?>)"><span class="glyphicon glyphicon-share-alt"></span> <span><?php echo __('公開'); ?></span></button>
</p>
</div>

<div id="announcements_post_<?php echo $frameId;?>">---</div>
debug : frameId:<?php echo $frameId;?><br>
debug : blockId:<?php echo $blockId;?>

