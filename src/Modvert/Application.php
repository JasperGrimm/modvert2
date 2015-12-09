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

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @return History
     */
    public function createHistory()
    {
        return History::getInstance()->setConnection($this->getConnection());
    }

    /**
     * @return Git
     */
    public function createRepo()
    {
        /** @var Git $git */
        return Git::getInstance()->path($this->app_path);
    }

    /**
     * 1. I'm on a HEAD of branch
     * 2. Check has unstaged?
     * 2.yes. Print error message
     * 3. Checkout to the last synced revision
     * 4. Check has changed files in the storage. Diff to the HEAD ?
     * 4.yes. Mark "Need For Push"
     * 5. Checkout to the HEAD of the branch
     * 6. Load resources data from the remote stage to the local storage
     * 7. Check has changed files in the storage ?
     * 7.yes. Commit changes and
     * @param $stage
     * @throws GitException
     */
    public function sync($stage)
    {
        $this->config() && $this->stage = $stage;
        /** @var Git $git */
        $git = $this->createRepo();
        try {
            $git->dropTempRemoteBranch();
        } catch (\Exception $ex) {}
        $main_branch = $git->getCurrentBranch();
        /** @var History $history */
        $history = $this->createHistory();
        $storage = new Storage($this->getConnection());
        if ($rev = $history->getLastSyncedRevision($main_branch)) {
            $last_sync_revision = $rev->revision;
        } else {
            throw new \Exception('Please run command `bin/modvert.cli.php init` before!');
        }
        $git->setLastSyncedRevision($last_sync_revision);

        if($git->hasUnstagedChanges()) {
            throw new GitException('Please commit your changes and try again!');
        }

        $git->checkoutToLastRevision();

        self::$need_for_push = !empty($git->diff($main_branch, $last_sync_revision));

        $git->checkoutToTempRemoteBranch();
        try {
            /**
             * Then load from remote
             */
            $storage->loadRemote($stage);
            if($git->hasUnstagedChanges()) {
                $git->fix();
                self::$need_merge = true;
            }
            $git->checkout($main_branch);
            if (self::$need_merge) {
                $git->mergeTempRemoteBranch();
            }
        } catch(\Exception $ex) {
            $git->checkout($main_branch);
            throw $ex;
        }
        $git->dropTempRemoteBranch();

        if (self::$need_for_push) {
            $git->refresh();
            $history->commit($git->getCurrentRevision(), $main_branch);
            die('Remote sync');
        }
    }

    public function init()
    {
        /** @var History $history */
        $history = $this->createHistory();
        $git = $this->createRepo();
        $history->commit($git->getCurrentRevision(), $git->getCurrentBranch());
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