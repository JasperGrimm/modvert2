<?php namespace Modvert\Web;

use Modvert\Application;
use Modvert\Driver\DatabaseDriver;
use Modvert\Exceptions\ModvertResourceException;
use Modvert\Resource\Repository;
use Modvert\Storage;
use PHPixie\HTTP;
use PHPixie\HTTP\Responses;
use PHPixie\Slice;

/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/6/2015
 * Time: 3:20 PM
 */
class Server
{

    /**
     * @var HTTP
     */
    private $http;

    /**
     * @param $data
     * @param int $code
     */
    private function response($data, $code=200)
    {
        $serializer = new \Zumba\Util\JsonSerializer();
        $json = $serializer->serialize($data);
        /** @var Responses $responses */
        $responses = $this->http->responses();
        $response = $responses->string($json);
        $response->headers()->set('Content-Type', 'application/json; charset=utf-8');
        $response->setStatus($code);
        $this->http->output($response);die();
    }

    private function request()
    {
        return $this->http->request();
    }

    public function handle()
    {
        $this->http = new HTTP(new Slice()); $request = $this->request();
        $repo = new Repository();
        $repo->setDriver(new DatabaseDriver(Application::getInstance()->getConnection()));
        if ('GET' === $request->method()) {
            $q = $request->query()->get('q');
            if (!$q) {
                $this->response(['error' => '?q must be specified!'], 500);
            }
            $path_info = explode('/', $q);

            $type = $path_info[0];
            if ('locks' === $type) {
                $this->response(['locks' => $repo->getLocks()]);
                return;
            }
            if (!$type || !in_array($type, ['chunk', 'snippet', 'content', 'tv', 'template', 'category']))
                $this->response(['error' => 'Type must be specified!'], 500);
            $pk = (count($path_info) > 1) ? $path_info[1] : null;
            if (!$pk) {
                try {
                    $items = $repo->getAll($type);
                    $items = array_map(function($item){
                        return $item->getData();
                    }, $items);
                } catch (ModvertResourceException $ex) {
                    $items = [];
                }
                $this->response($items);
            } else {
                try {
                    $resource = $repo->getOnce($type, $pk)->getData();
                } catch (ModvertResourceException $ex) {
                    $resource = null;
                }
                $this->response($resource);
            }
        } elseif ('POST' === $request->method()) {
            $action = $request->data()->getData('action');
            if ($action === 'remove_locks') {
                $repo->unlock();
                $this->response(['result' => 'ok'], 201);
            } elseif ($action === 'clear_cache') {
                $repo->clearCache();
                $this->response(['result' => 'ok'], 201);
            } else {
                $this->response(['error' => 'Unsupported operation!'], 500);
            }
        }
    }
}
