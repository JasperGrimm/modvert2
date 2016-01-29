<?php namespace Modvert\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
* 
*/
class ClearCacheCommand extends ModvertCommand
{
	
	protected $name = 'clear-cache';

	protected $description = 'Clear MODX cache';

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
		//[assets/cache/*.pageCache.php, assets/cache/siteCache.idx.php, assets/cache/sitePublishing.idx.php]
		$this->app->clearCache($input->getOption('stage'), $local);
		$output->writeln('<info>cache clearing complete!</info>');
	}
}