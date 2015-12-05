<?php namespace Modvert\Resource\Modx;
use Modvert\Resource\Resource;
use Modvert\Resource\ResourceType;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 11:16 PM
 */
class Category extends Resource
{

    protected $type = ResourceType::CATEGORY;

    protected $hidden_fields = [];


    public function getInfo()
    {
        return $this->data;
    }
}