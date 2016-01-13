<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 2:05 PM
 */

$root = __DIR__.'/../';
$path = str_replace('/', DIRECTORY_SEPARATOR, $root.'vendor/autoload.php');
if (file_exists($path)) {
   include_once $path;
} else{
   $path = str_replace('/', DIRECTORY_SEPARATOR, $root.'../vendor/autoload.php');
   if (file_exists($path)) {
       include_once $path;
   } else {
       $path = str_replace('/', DIRECTORY_SEPARATOR, $root.'../../autoload.php');
       if (file_exists($path)) {
           include_once $path;
       } else {
           echo 'Something goes wrong with your archive'.PHP_EOL.
               'Try downloading again'.PHP_EOL;
           exit(1);
       }
   }
}
define('TARGET_PATH', $_SERVER['DOCUMENT_ROOT']);
define('APP_ENV', 'production');

/** @var \Modvert\Application $app */
$app = \Modvert\Application::getInstance();
$app->setAppPath(TARGET_PATH);
$app->web();
