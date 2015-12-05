<?php namespace Modvert\Resource\Modx;
use Modvert\Resource\Resource;
use Modvert\Resource\ResourceType;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 11:16 PM
 */
class Template extends Resource
{

    protected $type = ResourceType::TEMPLATE;

    protected $hidden_fields = ['content'];


    public function getInfo()
    {
        return $this->getCleanFields();
    }
}