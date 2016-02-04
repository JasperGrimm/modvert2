<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 11:01 PM
 */

namespace Modvert\Serializer;


use Modvert\Resource\IResource;

interface ISerializer
{
    /**
     * @param IResource $resource
     * @return bool
     */
    public function serialize(IResource $resource);

    /**
     * @return IResource
     */
    public function deserialize($file);
}