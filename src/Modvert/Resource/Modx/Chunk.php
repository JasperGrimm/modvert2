<?php namespace Modvert\Resource\Modx;
use Modvert\Resource\Resource;
use Modvert\Resource\ResourceType;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 11:16 PM
 */
class Chunk extends Resource
{

    protected $type = ResourceType::CHUNK;

    protected $hidden_fields = [];


    public function getInfo()
    {
        $data = $this->data;
        unset($data['snippet']);
        $data['description'] = $this->specialEscape($data['description']);
        return $data;
    }

    public function getContent()
    {
        return $this->data['snippet'];
    }
}