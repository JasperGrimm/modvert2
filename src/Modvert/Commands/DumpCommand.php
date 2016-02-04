<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 3:03 AM
 */

namespace Modvert\Commands;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends ModvertCommand
{

    protected $name = 'dump';

    protected $description = 'load from database into files';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->app->dump($input->getOption('stage'));
    }

}