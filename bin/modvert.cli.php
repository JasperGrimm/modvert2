<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 2:05 PM
 */

use Symfony\Component\OptionsResolver\OptionsResolver;

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

define('TARGET_PATH', getcwd());

/** @var \Modvert\Application $app */
$app = \Modvert\Application::getInstance();
$app->setAppPath(TARGET_PATH);
$resolver = new OptionsResolver();
$resolver->setDefaults(['stage' => $app->config()->get('default_stage')]);
$options = getopt('', ['stage:']);
$options = $resolver->resolve($options);
$output = new Symfony\Component\Console\Output\ConsoleOutput();
$app->setOutput($output);
try {
    if (count($argv) >= 2 && $argv[1] == 'init') {
        $app->init();
    } else {
        $app->sync($options['stage']);
        $output->writeln('<info>Complete!</info>');
    }
} catch (\Exception $ex) {
    $output->writeln('<error>' . $ex->getMessage() . '</error>');
}
