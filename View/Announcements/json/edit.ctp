<?php
/**
 * announcements edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$tokens = $this->Token->getToken($tokenFields, $hiddenFields);
$results['announcement'] += $tokens;

//echo $this->element('NetCommons.json',
//		array('results' => $results));

if (!isset($name)) {
	$name = 'OK';
}
if (!isset($status)) {
	$status = 200;
}

$result = array(
	'code' => $status,
	'name' => $name,
	'results' => $results
);
$this->set(compact('result'));
$this->set('_serialize', 'result');

echo $this->render();