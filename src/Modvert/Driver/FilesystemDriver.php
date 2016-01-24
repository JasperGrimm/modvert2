<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 3:53 AM
 */

namespace Modvert\Driver;

use Modvert\Filesystem\FilesystemFactory;
use Modvert\Resource\IResource;

class FilesystemDriver implements IDriver
{
    /**
     * @param $type
     * @param $id
     * @return IResource
     */
    public function find($type, $id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @param $type
     * @return array
     */
    public function findAll($type)
    {
        $factory = FilesystemFactory::getReader($type);
        return $factory->read();
    }

    public function insert(IResource $resource)
    {
        // TODO: Implement insert() method.
    }

    public function update(IResource $resource)
    {
        // TODO: Implement update() method.
    }

    public function remove($type, $id)
    {
        // TODO: Implement remove() method.
    }

    public function truncate($type)
    {
        // TODO: Implement truncate() method.
    }

    /**
     * Return TRUE, if passed resource is different with this resource stored in current store
     *
     * @param IResource $resource
     * @return mixed
     */
    public function isChanged(IResource $resource)
    {
        // TODO: Implement isChanged() method.
    }

    public function isLocked()
    {
        // TODO: Implement isLocked() method.
    }

    public function getLocks()
    {
        // TODO: Implement getLocks() method.
    }

    public function unlock()
    {
        // TODO: Implement unlock() method.
    }

    public function truncateAll()
    {
        // TODO: Implement truncateAll() method.
    }
}