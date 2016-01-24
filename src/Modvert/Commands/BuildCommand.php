<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 3:05 AM
 */

namespace Modvert\Commands;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends ModvertCommand
{

    protected $name = 'build';

    protected $description = 'load from files to database [@Warning: all inmanager modifications will be lost!]';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->app->build($input->getOption('stage'));
    }

}