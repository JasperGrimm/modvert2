<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 2:55 AM
 */

namespace Modvert\Driver;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Modvert\Application;
use Modvert\Resource\IResource;
use Noodlehaus\Config;

class RemoteDriver implements IDriver
{

    /**
     * @var Config
     */
    protected $config;

    protected $stage;

    public function __construct($stage)
    {
        /** @var Application $app */
        $app = Application::getInstance();
        $this->config = $app->config();
        $this->client = new Client();
        $this->stage = $stage;
    }

    private function get($path)
    {
        $res = $this->client->request('GET', $this->config->get('stages.' . $this->stage)['remote_url'] . '?q=' . $path);
        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * @param $type
     * @param $id
     * @return IResource
     */
    public function find($type, $id)
    {
        return $this->get($type . '/' . $id);
    }

    public function findAll($type)
    {
        return $this->get($type) ? $this->get($type) : [];
    }

    public function insert(IResource $resource)
    {
        // TODO: Implement insert() method.
    }

    public function update(IResource $resource)
    {
        // TODO: Implement update() method.
    }

    public function remove($type, $id)
    {
        // TODO: Implement remove() method.
    }

    public function truncate($type)
    {
        // TODO: Implement truncate() method.
    }
    /**
     * Return TRUE, if passed resource is different with this resource stored in current store
     *
     * @param IResource $resource
     * @return mixed
     */
    public function isChanged(IResource $resource)
    {
        // TODO: Implement isChanged() method.
    }

    public function isLocked()
    {
        return $this->get('locked');
    }
}
