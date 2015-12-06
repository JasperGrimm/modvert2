<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 2:05 PM
 */

require __DIR__ . '/../vendor/autoload.php';

$app = \Modvert\Application::getInstance();
$app->setAppPath(realpath(getcwd() . DIRECTORY_SEPARATOR . '..'));

$app->web();