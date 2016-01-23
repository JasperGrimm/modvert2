<?php namespace Modvert\Resource\Modx;
use Modvert\Resource\Resource;
use Modvert\Resource\ResourceType;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 11:16 PM
 */
class Snippet extends Resource
{

    protected $type = ResourceType::SNIPPET;

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
    
    public function getRawData()
  	{
  		$data = $this->data;
  		$data['snippet'] = $data['content'];
  		unset($data['content']);
      return $data;
  	}
}
