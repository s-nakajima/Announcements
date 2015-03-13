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


title1: <?php echo isset($announcements['title1']) ? $announcements['title1'] : ''; ?>

<div>
	<?php echo isset($announcements['content']) ? $announcements['content'] : ''; ?>
</div>
