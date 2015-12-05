<?php namespace Modvert\Resource\Modx;
use Modvert\Resource\Resource;
use Modvert\Resource\ResourceType;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/4/2015
 * Time: 11:16 PM
 */
class Content extends Resource
{

    protected $type = ResourceType::CONTENT;

    protected $hidden_fields = [
        'pub_date',
        'unpub_date',
        'introtext',
        'richtext',
        'createdby',
        'createdon',
        'editedby',
        'editedon',
        'deletedon',
        'deletedby',
        'publishedon',
        'publishedby'
    ];


    public function getInfo()
    {
        $data = $this->data;
        $unavailable_keys = [
            'pub_date',
            'unpub_date',
            'introtext',
            'richtext',
            'createdby',
            'createdon',
            'editedby',
            'editedon',
            'deletedon',
            'deletedby',
            'publishedon',
            'publishedby',
            'content'
        ];
        $t_data = $data;
        foreach ($t_data as $key => $value) {
            if (in_array($key, $unavailable_keys)) {
                unset($data[$key]);
            }
        }
        return $data;
    }
}