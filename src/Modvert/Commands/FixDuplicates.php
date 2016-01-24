<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 2:46 AM
 */

namespace Modvert\Commands;


use Modvert\Driver\DatabaseDriver;
use Modvert\Driver\FilesystemDriver;
use Modvert\Resource\Repository;
use Modvert\Resource\ResourceType;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixDuplicates extends ModvertCommand
{
    protected $name = 'fix-duplicates';
    protected $description = 'Show conflicts';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $duplicates = [];
        foreach (ResourceType::asArray() as $type) {
            $duplicates[$type] = [];
            $repository = new Repository(new FilesystemDriver());
            $resources = $repository->getAll($type);
            $processed = [];
            $processed_names = [];
            /** @var \Modvert\Resource\Resource $resource */
            foreach ($resources as $resource) {
                $id = $resource->getId();
                if (in_array($id, $processed)) {
                    if (!array_key_exists($id, $duplicates[$type])) {
                        $duplicates[$type][$id] = [];
                    }
                    $duplicates[$type][$id][] = $processed_names[$id]; // previous duplicated
                    $duplicates[$type][$id][] = $resource->getName(); //
                }
                $processed_names[$id] = $resource->getName();
                $processed[] = $id;
            }
            if (!count($duplicates[$type])) unset($duplicates[$type]);
        }
        $this->display($duplicates);
    }

    private function display($duplicates)
    {
        if (!count($duplicates)) {
            $this->output->writeln('<info>You don\'t have any problems!</info>');
            return;
        }
        foreach ($duplicates as $type => $duplicate) {
            if (count($duplicate)) {
                $this->output->writeln('<question>' . $type . ':</question>');
                foreach ($duplicate as $item_id=>$items) {
                    $this->output->writeln('<info>    ' . $item_id . ':</info>');
                    foreach ($items as $item) {
                        $this->output->writeln('<info>        ' . $item . '</info>');
                    }
                }
            }
        }
    }

}