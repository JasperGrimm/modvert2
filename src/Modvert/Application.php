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

    /**
     * @var Config
     */
    protected $config;

    protected $stage;

    protected $app_path;

    /**
     * @var Connection
     */
    protected $connection;

    public function sync($stage)
    {
        $this->config() && $this->stage = $stage;
        /** @var Git $git */
        $git = Git::getInstance()->path($this->app_path);
        /** @var History $history */
        $history = History::getInstance()->setConnection($this->getConnection());
        $storage = new Storage($this->getConnection());

        $git->setLastSyncedRevision($history->getLastSyncedRevision($git->getCurrentBranch()));

        if($git->hasUnstagedChanges()) {
            throw new GitException('Please commit your changes!');
        }
        $git->checkoutToLastRevision();

        /**
         * Load from database to local files
         */
        $storage->loadLocal();

        /**
         * commit in the git repository
         */
        $git->fix();

        /**
         * Then load from remote
         */
        $storage->loadRemote($stage);

        /**
         * And commit in the repository again
         */
        $git->fix();
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