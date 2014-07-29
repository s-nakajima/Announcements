<!-- open -->
<ul class="nav nav-tabs" role="tablist">
	<li class="active">
		<span class="btn btn-default" ng-click="openTextEditor(<?php echo intval($frameId);?>)"
		>HTML</span></li>
	<li>
<a ng-click="openTextEditor(<?php echo intval($frameId);?>)"
	>TEXT</button></a></li>
</ul>

<!-- modal -->
<div
	class="modal fade bs-example-modal-lg"
	tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel"
	aria-hidden="true"
    id="announcements-text-editor-modal-<?php echo intval($frameId);?>"
>
	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><?php echo __("コード"); ?></h4>
		</div>
		<div class="modal-body">
			<textarea
				id="announcements-text-editor-<?php echo intval($frameId);?>"
				class="form-control"
				style="height: 150px;"
			></textarea>
		</div>
		<div class="modal-footer">
			<button
				class="btn btn-primary"
				ng-click="closeTextEditor(<?php echo intval($frameId);?>)"
				><?php echo __("閉じる"); ?></button>
		</div>
	</div>
	</div>
</div>