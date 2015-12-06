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

    public function path($path)
    {
        $this->path = $path;
        return $this;
    }

    public function fix()
    {
        $repo = new \PHPGit\Git();
        $repo->setRepository($this->path);
        // Retrive the current branch
        $br = array_filter($repo->branch(), function ($branch) {
            return $branch['current'];
        });
        $current_branch = $br[array_keys($br)[0]]['name'];
        $current_revision = $br[array_keys($br)[0]]['hash'];
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

    protected function getUnstagedChanges()
    {
        $changes = self::$repo->status()['changes'];
        if (count($changes)) {
            $changes = array_filter($changes, function ($item) {
                return $item['index'] !== '?'; // исключаем Untracked files
            });
        }
        return $changes;
    }

    protected function hasUnstagedChanges()
    {
        return count($this->getUnstagedChanges());
    }
}