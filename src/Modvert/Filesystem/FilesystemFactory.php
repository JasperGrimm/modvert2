<?php namespace Modvert\Filesystem;

use Modvert\Resource\ResourceType;

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
                return new ChunkWriter();
            case ResourceType::SNIPPET:
                return new SnippetWriter();
            case ResourceType::TV:
                return new TVWriter();
            case ResourceType::CONTENT:
                return new ContentWriter();
            case ResourceType::CATEGORY:
                return new CategoryWriter();
            case ResourceType::TEMPLATE:
                return new TemplateWriter();
            default:
                throw new \InvalidArgumentException("Type %$type% is incompatible");
        }
    }

}