<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 10:53 PM
 */

namespace Modvert;


class Application implements IModvert
{

    public function sync($stage)
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
        $storage = new Storage();
        $storage->setDatabaseConnection($connection);
        $storage->loadLocal();
    }
}