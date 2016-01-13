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
use PHPGit\Git;
use PHPixie\Database\Connection;
use Modvert\Web\Server;
use Modvert\Application;
use \Modvert\Helper\ArrayHelper;
use Modvert\Resource\Repository;
use Modvert\Driver\RemoteDriver;
use Modvert\Driver\DatabaseDriver;

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

    public function getOutput()
    {
      return $this->output;
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

    /**
     * [build description]
     * @param  [type] $stage [description]
     * @return [type]        [description]
     */
    public function build($stage)
    {
        /** @var $resource IResource **/
        $repository = new Repository();
        $driver = new DatabaseDriver($this->getConnection());
        $repository->setDriver($driver);

        if ($repository->isLocked()) { // If remote stage is Locked
            $this->output->writeln('<error>Local database is locked. Please try again!</error>');
            exit(1);
        }
        $this->output->writeln(sprintf('<info>[stage=%s]</info>', $stage));
        $this->config() && $this->stage = $stage;
        $storage = new Storage($this->getConnection());
        $storage->buildFromFiles();
    }

    /**
     * 1. Checkout to new branch modvert/test based on origin/test
     * or movert/develop based on origin/develop
     * 2. Load remote resources
     * 3. Show message:
     *   1. Check changes `git diff --name-only -- storage`
     *   2. Commit if has changes
     *   3. Checkout to the main branch (test/develop/feature/QUES-*)
     *   4. Merge `git merge movert/test` or `git merge movert/develop`
     *
     * Если
     */
    public function loadRemote($stage)
    {

        /** @var $resource IResource **/
        $repository = new Repository();
        $driver = new RemoteDriver($stage);
        $repository->setDriver($driver);

        if ($repository->isLocked()) { // If remote stage is Locked
            return $this->output->writeln('<error>Remote stage is locked. Please try again!</error>');
        }

        $storage = new Storage($this->getConnection());
        $git = new Git();
        $git->setRepository(Application::getInstance()->getAppPath());
        $status = $git->status();
        $current_branch = $status['branch'];
        // do not checkout if has unstaged changes
        if (count($status['changes'])) {
          return $this->output->writeln('<error>Please commit changes before!</error>');
        }

        $temp_branch = 'modvert/develop';
        $parent_branch = 'origin/develop';
        try {
            $git->branch->delete($temp_branch, ['force'=>true]);
        } catch(\Exception $ex) { /** the branch not found */ }

        $git->checkout->create($temp_branch, $parent_branch);

        $storage->loadRemote($stage);

        $storage_changes = ArrayHelper::matchValue($git->status()['changes'], 'file', '/^storage/');
        if (count($storage_changes)) {
          $this->output->writeln('<info>You have unstaged remote changes! Commit them and merge with main branch!</info>');
        } else {
          $git->checkout($current_branch);
        }
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
            $db_config = $this->config()->get('database' . (APP_ENV ==='test' ? '.test' : ''));
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
