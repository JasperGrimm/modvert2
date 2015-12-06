<?php namespace Modvert\Filesystem;
use Modvert\Resource\IResource;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 2:29 AM
 */
interface IResourceWriter
{
    public function write(IResource $resource);
}