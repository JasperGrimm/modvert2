<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Modvert\Application;

class Unit extends \Codeception\Module
{
    /**
     * @return \Modvert\Resource\Modx\Chunk
     */
    public function createChunk() {
        $data = [
            'id' => 1,
            'name' => 'HEADER',
            'description' => 'header stripe for main_site pages',
            'snippet' => '<header>Header stripe</header>'
        ];
        $r = new \Modvert\Resource\Modx\Chunk($data);
        return $r;
    }

    public function getConnection()
    {
        return Application::getInstance()->getConnection();
    }
}
