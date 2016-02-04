<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 2:53 AM
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