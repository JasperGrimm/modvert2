<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 3:19 AM
 */

namespace Modvert\Resource;


use Modvert\Resource\Modx\Category;
use Modvert\Resource\Modx\Chunk;
use Modvert\Resource\Modx\Content;
use Modvert\Resource\Modx\Snippet;
use Modvert\Resource\Modx\Template;
use Modvert\Resource\Modx\TV;

class ResourceFactory
{

    public static function get($type)
    {
        switch($type) {
            case ResourceType::CHUNK:
                return new Chunk();
            case ResourceType::SNIPPET:
                return new Snippet();
            case ResourceType::TV:
                return new TV();
            case ResourceType::CONTENT:
                return new Content();
            case ResourceType::CATEGORY:
                return new Category();
            case ResourceType::TEMPLATE:
                return new Template();
            default:
                throw new \InvalidArgumentException('Type is incompatible');
        }
    }

}