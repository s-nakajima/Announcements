<?php
/**
 * announcements manage template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php
	//管理ボタン
	echo $this->element('announcements/view/manage_nav');
?>

<div class="modal-body">
	<div class="tab-content">
		<div id="nc-announcements-edit-<?php echo $frameId; ?>"
				class="tab-pane active">

			<?php echo $this->requestAction('/announcements/announcement_edit/view/' . $frameId, array('return')); ?>
		</div>
	</div>
</div>
