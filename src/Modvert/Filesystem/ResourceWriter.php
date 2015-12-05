<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 10:27 AM
 */

namespace Modvert\Filesystem;


use Modvert\Resource\IResource;
use Modvert\Serializer\ISerializer;

class ResourceWriter implements IResourceWriter
{

    /**
     * @var ISerializer
     */
    protected $serializer;

    /**
     * CategoryWriter constructor.
     * @param $serializer
     */
    public function __construct(ISerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function write(IResource $resource)
    {
        $content = $this->serializer->serialize($resource);
        file_put_contents(getcwd() . DIRECTORY_SEPARATOR .
            'storage' . DIRECTORY_SEPARATOR . 'chunk' .
            DIRECTORY_SEPARATOR . $resource->getId(). '.model',
            $content
        );
    }
}