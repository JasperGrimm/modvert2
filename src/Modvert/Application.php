<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 10:53 PM
 */

namespace Modvert;

use Noodlehaus\Config;
use PHPGit\Exception\GitException;
use PHPixie\Database\Connection;
use Modvert\Web\Server;

class Application extends Singleton implements IModvert
{

    protected static $need_for_push = false;
    protected static $need_merge = false;

    /**
     * @var Config
     */
    protected $config;

    protected $stage;

    protected $app_path;

    protected $output;

    /**
     * @var Connection
     */
    protected $connection;

    public function setOutput($output)
    {
      $this->output = $output;
    }

    public function init()
    {
      if (!$this->app_path) $this->setAppPath(getcwd());
    }

    public function dump($stage)
    {
        $this->output->writeln(sprintf('<info>[stage=%s]</info>', $stage));
        $this->config() && $this->stage = $stage;
        $storage = new Storage($this->getConnection());
        //$storage->loadRemote($stage);
        $storage->loadLocal();
    }

    public function build($stage)
    {
        $this->output->writeln(sprintf('<info>[stage=%s]</info>', $stage));
        $this->config() && $this->stage = $stage;
        $storage = new Storage($this->getConnection());
        $storage->buildFromFiles();
    }

    public function config()
    {
        if (!$this->config) {
            $this->config = \Noodlehaus\Config::load($this->app_path . DIRECTORY_SEPARATOR . 'modvert.yml');
        }
        return $this->config;
    }

    public function setAppPath($app_path)
    {
        $this->app_path = $app_path;
    }

    public function getAppPath()
    {
      return $this->app_path;
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

    /**
     * Handle http request
     */
    public function web()
    {
        $server = new Server();
        $server->handle();
    }
}
