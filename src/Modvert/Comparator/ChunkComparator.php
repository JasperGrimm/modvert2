<?php namespace Modvert\Comparator;
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 12:55 AM
 */

use Modvert\Resource\IResource;
use Modvert\Resource\Modx\Chunk;

class ChunkComparator extends BaseComparator
{

    public function compare(IResource $resourceA, IResource $resourceB)
    {
        if ($resourceA instanceof Chunk && $resourceB instanceof Chunk) {
            return parent::compare($resourceA, $resourceB);
        }
        throw new \InvalidArgumentException('$resourceA and $resourceB must be an instance of Chunk');
    }
}
