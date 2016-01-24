<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 3:16 AM
 */

namespace Modvert\Commands;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadRemoteCommand extends ModvertCommand
{

    protected $name = 'load-remote';

    protected $description = 'load from remote stage into files [@Warning: all inmanager modifications will be lost!]';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->app->loadRemote($input->getOption('stage'));
    }

}