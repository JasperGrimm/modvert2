<?php namespace Modvert\Comparator;
use Modvert\Resource\IResource;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 12:52 AM
 */

interface IComparator
{

    public static function getInstance();

    public function compare(IResource $resourceA, IResource $resourceB);

}