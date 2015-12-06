<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 2:05 PM
 */

use Symfony\Component\OptionsResolver\OptionsResolver;

require __DIR__ . '/../vendor/autoload.php';

$app = \Modvert\Application::getInstance();

$resolver = new OptionsResolver();
$resolver->setDefaults(array(
    'stage'     => 'development'
));
$options = getopt('', ['stage:']);
$options = $resolver->resolve($options);
$app->sync($options['stage']);