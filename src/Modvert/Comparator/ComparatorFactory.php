<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 1:18 AM
 */

namespace Modvert\Comparator;


use Modvert\Resource\ResourceType;

class ComparatorFactory
{

    public static function get($type)
    {
        switch ($type) {
            case ResourceType::CHUNK:
                return ChunkComparator::getInstance();
            case ResourceType::CATEGORY:
                return CategoryComparator::getInstance();
            case ResourceType::SNIPPET:
                return SnippetComparator::getInstance();
            default:
                return null;
        }
    }

}