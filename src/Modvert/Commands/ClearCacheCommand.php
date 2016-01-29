<?php namespace Modvert\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
* 
*/
class ClearCacheCommand extends ModvertCommand
{
	
	protected $name = 'clear-cache';

	protected $description = 'Clear MODX cache';

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		//[assets/cache/*.pageCache.php, assets/cache/siteCache.idx.php, assets/cache/sitePublishing.idx.php]
		$cache_files = ["assets/cache/*.pageCache.php", "assets/cache/siteCache.idx.php", "assets/cache/sitePublishing.idx.php"];
		foreach ($cache_files as $file) {
			$output->writeln('<question>unlink ' . TARGET_PATH . "/" . $file . '</question>');			
			@unlink(TARGET_PATH . "/" . $file);
		}

		$output->writeln('<info>cache clearing complete!</info>');
	}
}