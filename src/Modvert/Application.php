<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 10:53 PM
 */

namespace Modvert;

use Noodlehaus\Config;
use PHPixie\Database\Connection;

class Application extends Singleton implements IModvert
{

    /**
     * @var Config
     */
    protected $config;

    protected $stage;

    /**
     * @var Connection
     */
    protected $connection;

    public function sync($stage)
    {
        $this->stage = $stage;
        $storage = new Storage($this->getConnection());
        $storage->loadLocal();
        $storage->loadRemote($stage);
    }

    public function config()
    {
        defined('TARGET_PATH') || define('TARGET_PATH', getcwd());
        if (!$this->config) {
            $this->config = \Noodlehaus\Config::load(TARGET_PATH . DIRECTORY_SEPARATOR . 'modvert.yml');
        }
        return $this->config;
    }

    public function stage()
    {
        return $this->stage;
    }

    public function getConnection()
    {
        if (!$this->connection) {
            $slice = new \PHPixie\Slice();
            $db_config = $this->config()->get('database');
            $dsn = sprintf('mysql:host=%s:%d;dbname=%s',
                $db_config['host'],
                $db_config['port'],
                $db_config['name']
            );
            $database = new \PHPixie\Database($slice->arrayData(array(
                'default' => array(
                    'driver' => 'pdo',
                    'connection' => $dsn,
                    'user' => $db_config['user'],
                    'password' => $db_config['password']
                )
            )));
            $this->connection = $database->get();
        }
        return $this->connection;
    }
}