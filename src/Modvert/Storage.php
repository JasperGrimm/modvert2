<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 2:10 AM
 */

namespace Modvert;

use Modvert\Driver\DatabaseDriver;
use Modvert\Driver\RemoteDriver;
use Modvert\Filesystem\FilesystemFactory;
use Modvert\Filesystem\ResourceWriter;
use Modvert\Resource\IResource;
use Modvert\Resource\Repository;
use Modvert\Resource\ResourceType;
use Modvert\Application;
use PHPixie\Database\Connection;

/**
 * Class Storage
 * @package Modvert
 */
class Storage implements IStorage
{
    /**
     * @var Connection $connection;
     */
    protected $connection;

    /**
     * Storage constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function setDatabaseConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getDatabaseConnection()
    {
        return $this->connection;
    }

    /**
     * Load resources all types from remote stage
     *
     * @return mixed
     */
    public function loadRemote($stage)
    {
        $repository = new Repository();
        $repository->setDriver(new RemoteDriver($stage));
        foreach (ResourceType::asArray() as $type) {
            $resources = $repository->getAll($type);
            $writer = FilesystemFactory::getWriter($type);
//            Application::getInstance()->getOutput()->writeln(sprintf('<question>count: %s; type:%s</question>', count($resources), $type));

            $progressBar = new \ProgressBar\Manager(0, count($resources) + 1, 80);
            $progressBar->setFormat('Import remote %current%/%max% [%bar%] %percent%% %resource_type%: %resource_name%');
            $progressBar->addReplacementRule('%resource_type%', 600, function ($buffer, $registry) use ($type){
                $max = 10;
                $c = strlen($type);
                if ($max > $c) {
                    $type = $type . implode('', array_fill(0, $max-$c, ' '));
                }
                return $type;
            });
            $progressBar->addReplacementRule('%resource_name%', 500, function ($buffer, $registry) {
                return implode('', array_fill(0, 40, ' '));
            });
            foreach ($resources as $i=>$resource) {
                $progressBar->update($i);
                $progressBar->addReplacementRule('%resource_name%', 500, function ($buffer, $registry) use ($resource){
                    $name = $resource->getName();
                    $max = 45;
                    $c = strlen($name);
                    if ($max > $c) {
                        $name = $name . implode('', array_fill(0, $max-$c, ' '));
                    }
                    return $name;
                });
                $writer->write($resource);
            }
        }
    }

    /**
     * Load resources all types from local database
     *
     * @return mixed
     */
    public function loadLocal()
    {
        $repository = new Repository();
        $driver = new DatabaseDriver($this->getDatabaseConnection());
        $repository->setDriver($driver);
        foreach (ResourceType::asArray() as $type) {
            $resources = $repository->getAll($type);
            $writer = FilesystemFactory::getWriter($type);
            $progressBar = new \ProgressBar\Manager(0, count($resources) + 1, 70);
            $progressBar->setFormat('Import %current%/%max% [%bar%] %percent%% %resource_type%: %resource_name%');
            $progressBar->addReplacementRule('%resource_type%', 600, function ($buffer, $registry) use ($type){
                $max = 10;
                $c = strlen($type);
                if ($max > $c) {
                    $type = $type . implode('', array_fill(0, $max-$c, ' '));
                }
                return $type;
            });
            $progressBar->addReplacementRule('%resource_name%', 500, function ($buffer, $registry) {
                return implode('', array_fill(0, 40, ' '));
            });
            foreach ($resources as $i=>$resource) {
                $progressBar->update($i);
                $progressBar->addReplacementRule('%resource_name%', 500, function ($buffer, $registry) use ($resource){
                    $name = $resource->getName();
                    $max = 45;
                    $c = strlen($name);
                    if ($max > $c) {
                        $name = $name . implode('', array_fill(0, $max-$c, ' '));
                    }
                    return $name;
                });
                $writer->write($resource);
            }
            echo PHP_EOL;
        }
        return [];
    }

    /**
     * Send resources all type to remote stage
     * @return mixed
     */
    public function pushToRemote($stage)
    {
        // TODO: Implement pushToRemote() method.
    }

    public function buildFromFiles()
    {
        /** @var $resource IResource **/
        $repository = new Repository();
        $driver = new DatabaseDriver($this->getDatabaseConnection());
        $repository->setDriver($driver);
        foreach (ResourceType::asArray() as $type) {
          $repository->truncate($type);
          $reader = FilesystemFactory::getReader($type);
          $resources = $reader->read();
          foreach ($resources as $resource) {
            $repository->add($resource);
          }
            // $resources = $repository->getAll($type);
            // $writer = FilesystemFactory::getWriter($type);
            // foreach ($resources as $resource) {
            //     $writer->write($resource);
            // }
        }
    }
}
