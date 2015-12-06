<?php namespace Modvert\Comparator;
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 12:55 AM
 */

use Modvert\Resource\IResource;
use Modvert\Resource\Modx\Chunk;

class ChunkComparator extends \Modvert\Singleton implements IComparator
{

    public function compare(IResource $resourceA, IResource $resourceB)
    {
        if ($resourceA instanceof Chunk && $resourceB instanceof Chunk) {
            $data_a = $resourceA->getCleanFields();
            $data_b = $resourceB->getCleanFields();
            $a = explode("\n", $data_a['snippet']);
            $b = explode("\n", $data_b['snippet']);
            $d = new \Diff($a, $b, []);
            $renderer = new \Diff_Renderer_Html_SideBySide;
            $diffc = $d->render($renderer);
            return !empty($diffc);
        }
        throw new \InvalidArgumentException('$resourceA and $resourceB must be an instance of Chunk');
    }
}