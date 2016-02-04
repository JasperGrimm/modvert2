<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 3:01 AM
 */

namespace Modvert\Commands;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends ModvertCommand
{

    protected $name = 'init';

    protected $description = 'Init modvert tool';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->app->init();
    }

}