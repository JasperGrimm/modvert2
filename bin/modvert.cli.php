<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 2:05 PM
 */

use Symfony\Component\OptionsResolver\OptionsResolver;

require __DIR__ . '/../vendor/autoload.php';

/** @var \Modvert\Application $app */
$app = \Modvert\Application::getInstance();

$resolver = new OptionsResolver();
$resolver->setDefaults(array(
    'stage'     => $app->config()->get('default_stage')
));
$options = getopt('', ['stage:']);
$options = $resolver->resolve($options);
$output = new Symfony\Component\Console\Output\ConsoleOutput();
try {
    $app->sync($options['stage']);
    $output->writeln('<info>Complete!</info>');
} catch (\Exception $ex) {
    $output->writeln('<error>' . $ex->getMessage() . '</error>');
}
