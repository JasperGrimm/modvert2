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
use Modvert\Resource\Repository;
use Modvert\Resource\ResourceType;
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
            foreach ($resources as $resource) {
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
            foreach ($resources as $resource) {
                $writer->write($resource);
            }
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
}