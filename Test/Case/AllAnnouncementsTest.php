<?php
/**
 * Announcements All Test Suite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Announcements All Test Suite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case
 * @codeCoverageIgnore
 */
class AllAnnouncementsTest extends CakeTestSuite {

/**
 * All test suite
 *
 * @return CakeTestSuite
 */
	public static function suite() {
		$plugin = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new CakeTestSuite(sprintf('All %s Plugin tests', $plugin));
		$task = 'AnnouncementsApp';
		var_dump($task);
		$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . DS . 'Controller' . DS . $task . 'Test.php');
		$task = 'AnnouncementAppModel';
		var_dump($task);
		$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . DS . 'Model' . DS . $task . 'Test.php');
		/* $task = 'AnnouncementsControllerError'; */
		/* var_dump($task); */
		/* $suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . DS . 'Controller' . DS . $task . 'Test.php'); */
		$task = 'AnnouncementsController';
		var_dump($task);
		$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . DS . 'Controller' . DS . $task . 'Test.php');
		/* $task = 'AnnouncementsControllerValidateError'; */
		/* var_dump($task); */
		/* $suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . DS . 'Controller' . DS . $task . 'Test.php'); */
		$task = 'Announcement';
		var_dump($task);
		$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . DS . 'Model' . DS . $task . 'Test.php');
		/* $suite->addTestDirectoryRecursive(CakePlugin::path($plugin) . 'Test' . DS . 'Case'); */
		return $suite;
	}
}
