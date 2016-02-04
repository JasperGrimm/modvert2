<?php
use Modvert\Application;
// This is global bootstrap for autoloading
require __DIR__ . '/../vendor/autoload.php';

$config_file = getcwd() . DIRECTORY_SEPARATOR . 'modvert.yml';

if (!file_exists($config_file)) throw new \Exception('Config file modvert.yml not found');
define('TARGET_PATH', getcwd());
if (getenv('ENV')) {
  define('APP_ENV', getenv('ENV'));
} else {
  define('APP_ENV', 'production');
}
// define('APP_ENV', ('')'test');
$output = new Symfony\Component\Console\Output\ConsoleOutput();
$app = Application::getInstance();
$app->setOutput($output);
$app->init();
