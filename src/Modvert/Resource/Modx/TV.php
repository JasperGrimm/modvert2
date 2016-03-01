<?php namespace Modvert\Resource\Modx;
use Modvert\Resource\Resource;
use Modvert\Resource\ResourceType;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 11:16 PM
 */
class TV extends Resource
{

    protected $type = ResourceType::TV;

    protected $hidden_fields = [];


    public function getInfo()
    {
        $data = $this->data;
        $data['default_text'] = addslashes($data['default_text']);
        $data['elements'] = $data['elements'];
        return $data;
    }

    public function getContent()
    {
        // TODO: Implement getContent() method.
    }

    public function getTemplates()
    {
        return $this->data['templates'];
    }

    public function getContentValues()
    {
        return $this->data['content_values'];
    }
}