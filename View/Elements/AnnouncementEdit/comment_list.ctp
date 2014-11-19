<?php
/**
 * announcement edit view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="panel-body">
	<div ng-repeat="comment in comments.data">
		<div ng-hide="$first"><hr /></div>
		<div>
			<a href="" ng-click="showUser(comment.Comment.created_user)">
				<b>{{comment.CreatedUser.value}}</b>
			</a>

			<small class="text-muted">{{comment.Comment.created}}</small>
		</div>
		<div>
			{{comment.Comment.comment}}
		</div>
	</div>

	<hr />

	<button type="button" class="btn btn-default btn-block"
			ng-show="comments.hasNext"
			ng-click="getComments(comments.current + 1)">
		<?php echo __d('net_commons', 'More'); ?>
	</button>

	<div class="text-right" ng-hide="(comments.current === 0)">
		<button type="button" class="btn btn-default btn-sm" ng-click="gotoTop()">
			<?php echo __d('net_commons', 'Top'); ?>
		</button>
	</div>

</div>
