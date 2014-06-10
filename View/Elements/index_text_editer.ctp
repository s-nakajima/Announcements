<!-- open -->
<a ng-click="openTextEditer(<?php echo intval($frameId);?>)"
    class="btn "
	>TEXT</a>

<!-- modal -->
<div
	class="modal fade bs-example-modal-lg"
	tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel"
	aria-hidden="true"
    id="announcements-text-editer-modal-<?php echo intval($frameId);?>"
>
	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><?php echo __("コード"); ?></h4>
		</div>
		<div class="modal-body">
			<textarea
				id="announcements-text-editer-<?php echo intval($frameId);?>"
				class="form-control"
				style="height: 150px;"
			></textarea>
		</div>
		<div class="modal-footer">
			<button
				class="btn btn-primary"
				ng-click="closeTextEditer(<?php echo intval($frameId);?>)"
				><?php echo __("閉じる"); ?></button>
		</div>
	</div>
	</div>
</div>