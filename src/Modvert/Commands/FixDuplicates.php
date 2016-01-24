<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 2:46 AM
 */

namespace Modvert\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixDuplicates extends ModvertCommand
{
    protected $name = 'fix_duplicates';
    protected $description = 'Show conflicts';

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }

}