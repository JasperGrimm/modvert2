<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 3:53 AM
 */

namespace Modvert\Driver;

use Modvert\Filesystem\FilesystemFactory;
use Modvert\Filesystem\Helper;
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
        $path = TARGET_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $type;
        Helper::delTree($path, ['.gitignore']);
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

    public function clearCache()
    {
        $cache_files = ["assets/cache/*.pageCache.php", "assets/cache/siteCache.idx.php", "assets/cache/sitePublishing.idx.php"];
        foreach ($cache_files as $file) {
            $output->writeln('<question>unlink ' . TARGET_PATH . "/" . $file . '</question>');          
            @unlink(TARGET_PATH . "/" . $file);
        }
        return true;
    }
}