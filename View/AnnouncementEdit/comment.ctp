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
<?php

$result = array(
	'comments' => array(
		'data' => $comments,
		'current' => $this->Paginator->current(),
		'hasPrev' => $this->Paginator->hasPrev(),
		'hasNext' => $this->Paginator->hasNext(),
	)
);

echo json_encode($result);