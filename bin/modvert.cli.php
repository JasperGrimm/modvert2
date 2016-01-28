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

$application = new Application();
$application->add(new \Modvert\Commands\FixDuplicates());
$application->add(new \Modvert\Commands\InitCommand());
$application->add(new \Modvert\Commands\BuildCommand());
$application->add(new \Modvert\Commands\DumpCommand());
$application->add(new \Modvert\Commands\LoadRemoteCommand());
$application->add(new \Modvert\Commands\UnlockCommand());
$application->add(new \Modvert\Commands\GetLocksCommand());
$application->run();