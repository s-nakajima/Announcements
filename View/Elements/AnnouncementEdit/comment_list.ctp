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

<div class="panel-heading">
	<?php echo __d('net_commons', 'Comment list'); ?>
</div>

<div class="panel-body">
	<div class="row" ng-repeat="comment in comments.data">
		<div class="col-sm-12" ng-hide="$first"><hr /></div>
		<div class="col-sm-4">
			{{comment.Announcement.created}}
			<br />
			<a href="" ng-click="showUser(comment.Announcement.created_user)">
				{{comment.CreatedUser.value | limitTo:<?php echo Announcement::NICKNAME_LENGTH ?>}}
			</a>
		</div>
		<div class="col-sm-8">
			<a href="" onclick="$(this).popover('show');" tabindex="1"
				data-toggle="popover"
				data-trigger="focus"
				data-placement="top"
				data-content="{{comment.Announcement.comment}}">

				{{comment.Announcement.comment | limitTo:<?php echo Announcement::COMMENT_LENGTH ?>}}
			</a>
		</div>
	</div>

	<hr />
	<ul class="pager">
		<li class="previous" ng-class="comments.hasPrev ? '' : 'disabled'">
			<a href="" ng-click="prevComments()">
				<?php echo __d('net_commons', 'Prev.'); ?>
			</a>
		</li>
		<li class="next" ng-class="comments.hasNext ? '' : 'disabled'">
			<a href="" ng-click="nextComments()">
				<?php echo __d('net_commons', 'Next'); ?>
			</a>
		</li>
	</ul>
</div>
