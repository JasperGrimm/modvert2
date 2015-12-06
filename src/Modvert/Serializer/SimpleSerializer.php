<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 04/10/15
 * Time: 02:23
 */

namespace Modvert\Serializer;

use Modvert\Resource\IResource;
use Modvert\Templating;

class SimpleSerializer extends Serializer
{
    public function serialize(IResource $resource)
    {
        $content = Templating::render('simple.html.twig', ['data' => $resource->getStringInfo()]);
        return $content;
    }

    public function deserialize($file)
    {
        return include $file;
    }
}