<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 2/15/2016
 * Time: 5:32 PM
 */

namespace Modvert\Commands;


use Modvert\Application;
use Modvert\Driver\DatabaseDriver;
use Modvert\Filesystem\FilesystemFactory;
use Modvert\Filesystem\ResourceReader;
use Modvert\Resource\ResourceType;
use Modvert\Storage;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WatchCommand extends ModvertCommand
{

    protected $name = 'watch';

    protected $description = 'Watch file-based resource and save it into DB when modified';

    public function configure()
    {
        parent::configure();
        $this->addArgument('filename', InputArgument::OPTIONAL);
    }

    protected function updateResource($filename) {
        $driver = new DatabaseDriver(Application::getInstance()->getConnection());
        $type =ResourceType::fromPath($filename);
        if (ResourceType::TV == $type) {
            throw new \Exception('Live update for TV do not allowed!');
        } else {
            $reader = FilesystemFactory::getReader($type);
            $driver->update($reader->readOnce($filename));
        }
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $files = new \Illuminate\Filesystem\Filesystem;
        $tracker = new \JasonLewis\ResourceWatcher\Tracker;
        $watcher = new \JasonLewis\ResourceWatcher\Watcher($tracker, $files);
        $watch_path =  Application::getInstance()->getAppPath() . DIRECTORY_SEPARATOR;
        if ($input->getArgument('filename')) {
            $watch_path .= $input->getArgument('filename');
        } else {
            $watch_path .= 'storage'; // watch whole storage
        }
        $listener = $watcher->watch($watch_path);
        $listener->modify(function($resource, $path) use ($output){
            $output->writeln("{$path} has been modified.");
            $this->updateResource($path);
        });
        $watcher->start();
    }
}