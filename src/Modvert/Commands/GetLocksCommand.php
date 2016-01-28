<?php namespace Modvert\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
* 
*/
class GetLocksCommand extends ModvertCommand
{
	
	protected $name = 'get-locks';

	protected $description = 'Get database locked resources';


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
		$local = $input->getArgument('local');
		$locks = $this->app->getLocks($input->getOption('stage'), $local);

		$output->writeln('<info>Locked resources:</info>');

		foreach ($locks as $lock) {
			$output->writeln($lock);
		}
	}

}

