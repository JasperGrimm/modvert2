<?php namespace Modvert\Filesystem;

use Modvert\Resource\ResourceType;
use Modvert\Serializer\HTMLSerializer;
use Modvert\Serializer\PHPSerializer;
use Modvert\Serializer\SimpleSerializer;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 3:46 AM
 */
class FilesystemFactory
{

    public static function getWriter($type)
    {
        switch($type) {
            case ResourceType::CHUNK:
            case ResourceType::CONTENT:
            case ResourceType::TEMPLATE:
                return new ResourceWriter(new HTMLSerializer());
            case ResourceType::SNIPPET:
                return new ResourceWriter(new PHPSerializer());
            case ResourceType::TV:
            case ResourceType::CATEGORY:
                return new ResourceWriter(new SimpleSerializer());
            default:
                throw new \InvalidArgumentException("Type %$type% is incompatible");
        }
    }

}