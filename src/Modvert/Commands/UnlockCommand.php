<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 3:23 AM
 */

namespace Modvert\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class UnlockCommand extends ModvertCommand
{

    protected $name = 'unlock';

    protected $description = 'unlock remote stage [@Warning: all inmanager modifications can be lost!]';

    protected function configure()
    {
      parent::configure();
          $this->addArgument(
                  'local',
                  InputArgument::OPTIONAL,
                  'Remote stage',
                  false
              )
          ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ('yes' === $this->ask('Are you really wants to unlock remote stage? [no]: ')) {
            $local = $input->getArgument('local');
            $this->app->unlockRemote($input->getOption('stage'), $local);
            $output->writeln('<info>Complete!</info>');
        }
    }

}
