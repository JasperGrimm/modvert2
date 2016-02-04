<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 2:05 PM
 */

include_once 'autoload.php';
define('TARGET_PATH', $_SERVER['DOCUMENT_ROOT']);
define('APP_ENV', 'production');

/** @var \Modvert\Application $app */
$app = \Modvert\Application::getInstance();
$app->setAppPath(TARGET_PATH);
$app->web();
