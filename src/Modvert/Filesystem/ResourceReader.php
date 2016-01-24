<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 10:27 AM
 */

namespace Modvert\Filesystem;


use Modvert\Resource\IResource;
use Modvert\Resource\ResourceType;
use Modvert\Resource\ResourceFactory;
use Modvert\Serializer\ISerializer;

class ResourceReader implements IResourceReader
{

    /**
     * @var ISerializer
     */
    protected $serializer;

    protected $type;

    protected $path;

    /**
     * CategoryWriter constructor.
     * @param $serializer
     */
    public function __construct(ISerializer $serializer, $type)
    {
        $this->serializer = $serializer;
        $this->type = $type;
        $this->path = TARGET_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $type;
    }

    /**
     * @return array
     */
    public function read()
    {
        $resources = [];
        $files = scandir($this->path);
        foreach ($files as $file) {
          if (!in_array($file, ['.', '..'])) {
            $resource_data = $this->serializer->deserialize($this->path . DIRECTORY_SEPARATOR . $file);
            $resource = ResourceFactory::get($this->type);
            $resource->setData($resource_data);
            $resources[] = $resource;
          }
        }
        return $resources;
    }
}
