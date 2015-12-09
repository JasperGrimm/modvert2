<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 5:57 PM
 */

namespace Modvert;


final class Git extends Singleton
{

    private $path;

    /**
     * @var \PHPGit\Git
     */
    private $repo;

    private $current_branch;

    private $current_revision;

    private $last_synced_revision;

    public function getCurrentBranch()
    {
        return $this->current_branch;
    }

    public function getCurrentRevision()
    {
        return $this->current_revision;
    }

    public function path($path)
    {
        $this->path = $path;
        $this->repo = new \PHPGit\Git();
        $this->repo->setRepository($this->path);
        // Retrive the current branch
        $br = array_filter($this->repo->branch(), function ($branch) {
            return $branch['current'];
        });
        $this->current_branch = $br[array_keys($br)[0]]['name'];
        $this->current_revision = $br[array_keys($br)[0]]['hash'];
        return $this;
    }

    public function fix()
    {

    }

    public function diff($from, $to)
    {
        $output = null;
        exec('git diff --name-only ' . $to . ' ' . $from . ' ' . TARGET_PATH . DIRECTORY_SEPARATOR . 'storage', $output);
        $output = array_map(function ($item) {
            $item = preg_replace_callback('/\\\\[0-7]{3}/', function ($matches) {
                return chr(octdec($matches[0]));
            }, $item);
            return str_replace('"', '', $item);
        }, $output);
        return $output;
    }

    public function getUnstagedChanges()
    {
        $changes = $this->repo->status()['changes'];
        if (count($changes)) {
            $changes = array_filter($changes, function ($item) {
                return $item['index'] !== '?'; // исключаем Untracked files
            });
        }
        return $changes;
    }

    public function hasUnstagedChanges()
    {
        return count($this->getUnstagedChanges());
    }

    public function setLastSyncedRevision($revision)
    {
        $this->last_synced_revision = $revision;
    }

    public function getLastSyncedRevision()
    {
        return $this->last_synced_revision;
    }

    public function checkoutToLastRevision()
    {
        $this->checkout($this->getLastSyncedRevision());
    }

    public function checkout($revision)
    {
        $this->repo->checkout($revision);
    }

    public function checkoutToTempRemoteBranch()
    {
        return $this->repo->checkout->create('modvert/RB', $this->last_synced_revision);
    }

    public function dropTempRemoteBranch()
    {
        return $this->repo->branch->delete('modvert/RB', ['force'=>1]);
    }

    public function mergeTempRemoteBranch()
    {
        return $this->repo->merge('modvert/RB');
    }
}