<?php namespace Modvert\Commands;

use Modvert\Filesystem\FilesystemFactory;
use Modvert\Resource\ResourceType;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
* 
*/
class NextIdCommand extends ModvertCommand
{
	
	protected $name = 'next-id';

	protected $description = 'Generate next ID for the passed resource type';

	protected function configure()
	{
		parent::configure();
        $this->addArgument('type', InputArgument::REQUIRED, 'Resource type');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$type = $input->getArgument('type');
		if (!in_array($type, ResourceType::asArray())) throw new \Exception('Данный тип не поддерживается');
		$reader = FilesystemFactory::getReader($type);
		$ids = [0];
		foreach ($reader->read() as $item) {
			$ids[] = $item->getId();
		}
		$output->writeln(sprintf('<info>Next ID for the %s:</info> <question>%d</question>', $type, max($ids) + 1));
	}
}