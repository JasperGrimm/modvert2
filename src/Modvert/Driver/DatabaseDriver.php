<?php namespace Modvert\Driver;

use Modvert\Resource\IResource;
use Modvert\Resource\ResourceType;
use PHPixie\Database\Connection;

class DatabaseDriver implements IDriver {

    protected $table_map = [
        ResourceType::CHUNK => 'modx_site_htmlsnippets',
        ResourceType::SNIPPET => 'modx_site_snippets',
        ResourceType::CONTENT => 'modx_site_content',
        ResourceType::CATEGORY => 'modx_categories',
        ResourceType::TEMPLATE => 'modx_site_templates',
        ResourceType::TV => 'modx_site_tmplvars'
    ];

    /**
     * @var Connection
     */
    private $connection;

    /**
     * DatabaseDriver constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        if (!$connection) throw new \InvalidArgumentException('Connection must be specified. But null passed');
        $this->connection = $connection;
    }

    /**
     * @param string $type
     * @param int $id
     * @return IResource
     */
    public function find($type, $id)
    {
        $items = $this->connection->selectQuery()
            ->table($this->table_map[$type])
            ->where('id', $id)
            ->limit(1)
            ->execute();
        return $items&&count($items) ? $items[0] : null;
    }

    /**
     * @param $type
     * @return mixed
     */
    public function findAll($type)
    {
        $items = $this->connection->selectQuery()
            ->table($this->table_map[$type])
            ->execute();
        return $items;
    }

    public function insert(IResource $resource)
    {
        // TODO: Implement insert() method.
    }

    public function update(IResource $resource)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $type
     * @param $id
     */
    public function remove($type, $id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * ?????????? TRUE, ???? ?????????? ?????? ??? ???????
     * ????????? ???? ? ???????, ?????????? ? ?????????, ????????????? ??????? ?????????.
     * ????????, ???? ??? ??????? ??, ?? ?????????? ?????? ????? ???????????? ? ???????,
     * ?????????? ? ??
     *
     * @param IResource $resource
     * @return mixed
     */
    public function isChanged(IResource $resource)
    {

    }
}