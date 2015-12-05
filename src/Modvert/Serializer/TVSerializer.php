<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 04/10/15
 * Time: 02:23
 */

namespace Modvert\Serializer;


use Modvert\Resource\Resource;
use Qst\App;
use Qst\ResourceModel;

class TVSerializer extends Serializer
{
    public function serialize(Resource $resource)
    {
        $path = $this->serializedModelPath . $resource->getType() . '/' . $resource->getName() . '.model';
        if (!file_exists(dirname($path))) mkdir(dirname($path));
        $content = App::render('tv.html.twig', [
            'data' => $resource->getStringInfo(),
        ]);
        $written = $this->writeFile($path, $content);
        return $written;
    }

    public function deserialize($path)
    {
        return include($path);
    }
}