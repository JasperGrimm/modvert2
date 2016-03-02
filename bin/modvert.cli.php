<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 2:05 PM
 */

include_once 'autoload.php';

define('TARGET_PATH', getcwd());
define('APP_ENV', 'production');
/** @var \Modvert\Application $app */
$app = \Modvert\Application::getInstance();
$app->setAppPath(TARGET_PATH);

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;

$application = new Application();
$application->add(new \Modvert\Commands\FixDuplicates());
$application->add(new \Modvert\Commands\InitCommand());
$application->add(new \Modvert\Commands\BuildCommand());
$application->add(new \Modvert\Commands\DumpCommand());
$application->add(new \Modvert\Commands\LoadRemoteCommand());
$application->add(new \Modvert\Commands\UnlockCommand());
$application->add(new \Modvert\Commands\GetLocksCommand());
$application->add(new \Modvert\Commands\ClearCacheCommand());
$application->add(new \Modvert\Commands\WatchCommand());
$application->add(new \Modvert\Commands\NextIdCommand());
try{
    $application->run();
} catch(\Exception $ex) {
  $output = new ConsoleOutput();
  $output->writeln('<error>' . $ex->getMessage() . '</error>');
}
