<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 10:51 PM
 */

namespace Modvert\Resource;


use Modvert\Driver\IDriver;
use Modvert\Driver\RemoteDriver;
use Modvert\Resource\IResource;

class Repository implements IRepository
{
    /**
     * @var IDriver
     */
    protected $driver;

    public function setDriver(IDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Get collection of IResource
     * @param $type string
     * @return Array<IResource>
     */
    public function getAll($type)
    {
        $resources = [];
        $items = $this->driver->findAll($type);
        foreach ($items as $item) {
            $resource = ResourceFactory::get($type);
            $resource->setData($item);
            $resources[] = $resource;
        }
        return $resources;
    }

    /**
     * @param $type string
     * @param $id int
     * @return IResource
     */
    public function getOnce($type, $id)
    {
        $resource = ResourceFactory::get($type);
        $resource->setData($this->driver->find($type, $id));
        return $resource;
    }

    /**
     * @param $resources Array<IResource>
     * @return bool
     */
    public function updateAll($resources)
    {
        foreach ($resources as $resource) {
            $this->updateOnce($resource);
        }
    }

    /**
     * @param $resource IResource
     * @return bool
     */
    public function updateOnce(IResource $resource)
    {
        $this->driver->update($resource);
    }

    public function truncate($type)
    {
        $this->driver->truncate($type);
    }

    public function add(IResource $resource)
    {
       $this->driver->insert($resource);
    }
}
