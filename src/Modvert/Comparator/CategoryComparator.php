<?php namespace Modvert\Comparator;
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 12:55 AM
 */

use Modvert\Resource\IResource;
use Modvert\Resource\Modx\Category;
use Modvert\Resource\Modx\Chunk;

class CategoryComparator extends \Modvert\Singleton implements IComparator
{

    public function compare(IResource $resourceA, IResource $resourceB)
    {
        if ($resourceA instanceof Category && $resourceB instanceof Category) {
            return false; // there is nothing to compare
        }
        throw new \InvalidArgumentException('$resourceA and $resourceB must be an instance of Category');
    }
}
