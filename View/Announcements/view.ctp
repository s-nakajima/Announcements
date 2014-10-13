<?php
/**
 * announcements view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php //echo $this->Html->script('/announcements/js/announcements.js', array('inline' => false)); ?>

<?php if ($contentEditable) : ?>
	<div id="nc-announcements-<?php echo (int)$frameId; ?>"
		 ng-controller="Announcements"
		 ng-init="initialize(<?php echo (int)$frameId; ?>,
								<?php echo h(json_encode($announcement)); ?>)">

<?php else : ?>
	<div>

<?php endif; ?>

	<?php
	//管理ボタン
	echo $this->element('announcements/view/manage_button');

	//本文
	echo $this->element('announcements/view/content');
	?>

</div>