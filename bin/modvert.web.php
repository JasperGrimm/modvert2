<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 2:05 PM
 */

require __DIR__ . '/../vendor/autoload.php';

define('TARGET_PATH', realpath(getcwd() . DIRECTORY_SEPARATOR . '..'));

/** @var \Modvert\Application $app */
$app = \Modvert\Application::getInstance();
$app->setAppPath(TARGET_PATH);
$app->web();