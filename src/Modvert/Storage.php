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
use Modvert\Resource\Repository;
use Modvert\Resource\ResourceType;

class Storage implements IStorage
{

    /**
     * ????????? ??????? ???? ????? ? ??????????? ?? ?????????? ?????????? stage
     *
     * @return mixed
     */
    public function loadRemote($stage)
    {
        $repository = new Repository();
        $repository->setDriver(new RemoteDriver($stage));
        foreach (ResourceType::asArray() as $type) {
            $resources = $repository->getAll($type);
        }
    }

    /**
     * ????????? ??????? ???? ????? ? ??????????? ?? ????????? ??
     *
     * @return mixed
     */
    public function loadLocal()
    {
        $slice = new \PHPixie\Slice();
        $database = new \PHPixie\Database($slice->arrayData(array(
            'default' => array(
                'driver' => 'pdo',
                'connection' => 'mysql:host=localhost:33060;dbname=akorsun_questoria_prod',
                'user' => 'homestead',
                'password' => 'secret'
            )
        )));
        $connection = $database->get();
        $repository = new Repository();
        $repository->setDriver(new DatabaseDriver($connection));
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
     * ????????? ??????? ???? ????? ? ????????? ????????? stage
     * @return mixed
     */
    public function pushToRemote($stage)
    {
        // TODO: Implement pushToRemote() method.
    }
}