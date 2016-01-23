<?php namespace Modvert\Driver;

use Modvert\Resource\IResource;
use Modvert\Resource\ResourceType;
use PHPixie\Database\Connection;
use Modvert\StringUtil;

class DatabaseDriver implements IDriver {

    protected $table_map = [
        ResourceType::CHUNK => 'modx_site_htmlsnippets',
        ResourceType::SNIPPET => 'modx_site_snippets',
        ResourceType::CONTENT => 'modx_site_content',
        ResourceType::CATEGORY => 'modx_categories',
        ResourceType::TEMPLATE => 'modx_site_templates',
        ResourceType::TV => 'modx_site_tmplvars'
    ];

    protected $resource_types = [
        16 => ResourceType::TEMPLATE,
        22 => ResourceType::SNIPPET,
        27 => ResourceType::CONTENT,
        78 => ResourceType::CHUNK,
        102 => 'plugins',
        301 => ResourceType::TV
    ];

    protected $resource_types_reversed = [
        ResourceType::TEMPLATE => 16,
        ResourceType::SNIPPET => 22,
        ResourceType::CONTENT => 27,
        ResourceType::CHUNK => 78,
        'plugins' => 102,
        ResourceType::TV => 301
    ];

    protected $tv_templates_table = 'modx_site_tmplvar_templates';
    protected $tv_content_values_table = 'modx_site_tmplvar_contentvalues';

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
        $item = ($items && count($items)) ? $items->current() : null;

        if ($type === ResourceType::TV) {
          $items = $this->connection->selectQuery()
              ->table($this->tv_templates_table)
              ->fields(['templateid'])
              ->where('tmplvarid', $id)
              ->execute();
          $item['templates'] = $items;
          $items = $this->connection->selectQuery()
              ->table($this->tv_content_values_table)
              ->fields(['contentid', 'value'])
              ->where('tmplvarid', $id)
              ->execute();
          $item['content_values'] = $items;
        }

        return $item;
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

        if ($type === ResourceType::TV) {
          $result = [];

          foreach ($items as $key => $item) {
            $item = (array) $item;
            $t_items = $this->connection->selectQuery()
                ->table($this->tv_templates_table)
                ->fields(['templateid'])
                ->where('tmplvarid', $item['id'])
                ->execute();
            $t_values = [];
            foreach ($t_items->asArray() as $t_item) {
              $t_values[] = $t_item->templateid;
            }
            $item['templates'] = $t_values;
            $c_items = $this->connection->selectQuery()
                ->table($this->tv_content_values_table)
                ->fields(['contentid', 'value'])
                ->where('tmplvarid', $item['id'])
                ->execute();
            $c_values = [];
            foreach ($c_items->asArray() as $c_item) {
              $c_values[$c_item->contentid] = StringUtil::specialEscape($c_item->value);
            }
            $item['content_values'] = $c_values;
            $result[$key] = (object)$item;
          }
          $items = $result;
        }
        return $items;
    }

    public function insert(IResource $resource)
    {
        try {
           if (ResourceType::TV === $resource->getType()) {

                $tv_data = $resource->getRawData();
                unset($tv_data['content_values'], $tv_data['templates']);
                $this->connection->insertQuery()
                  ->table($this->table_map[$resource->getType()])
                  ->data($tv_data)
                  ->execute();

               $templates = [];
               foreach ($resource->getTemplates() as $templateid) {
                 $templates[] = [$templateid, $resource->getId()];
               }
               if (count($templates)) {
                 $this->connection->insertQuery()
                   ->table($this->tv_templates_table)
                   ->batchData(
                      ['templateid', 'tmplvarid'],
                      $templates
                   )
                   ->execute();
               }
               $content_values = [];
               foreach ($resource->getContentValues() as $contentid => $value) {
                 $content_values[] = [$contentid, $resource->getId(), $value];
               }
               if (count($content_values)) {
                 $this->connection->insertQuery()
                   ->table($this->tv_content_values_table)
                   ->batchData(
                      ['contentid', 'tmplvarid', 'value'],
                      $content_values
                   )
                   ->execute();
               }
           } else {
              $this->connection->insertQuery()
                 ->table($this->table_map[$resource->getType()])
                 ->data($resource->getRawData())
                 ->execute();
           }
        } catch (\Exception $ex) {
          die(dump($resource, $ex->getMessage()));
        }
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

    public function truncate($type)
    {
        $this->connection->deleteQuery()
          ->table($this->table_map[$type])
          ->execute();
        if (ResourceType::TV === $type) {
            $this->connection->deleteQuery()
              ->table($this->tv_templates_table)
              ->execute();
            $this->connection->deleteQuery()
              ->table($this->tv_content_values_table)
              ->execute();
        }
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

    public function isLocked()
    {
        $locks = $this->getLocks();
        return (0 < count($locks)); 
    }

    public function getLockedResourceName($action, $id)
    {
        $fields = ['name', 'id'];
        $type = $this->resource_types[$action];
        if (ResourceType::CONTENT === $type) {
            $fields = ['alias', 'id'];
        }
        $r = $this->connection->selectQuery()
            ->table($this->table_map[$type])
            ->fields($fields)
            ->where('id', $id)
            ->execute();
        return $type . ': ' . $r->get('id') . ' - ' . $r->get();
    }

    /**
     * Возвращает
     */
    public function getLocks()
    {
        $locks = $this->connection->selectQuery()
            ->table('modx_active_users')
            ->and('action', $this->resource_types_reversed[ResourceType::CHUNK]) // htmlsnippets
            ->or('action', $this->resource_types_reversed[ResourceType::CONTENT]) // content
            ->or('action', $this->resource_types_reversed[ResourceType::TEMPLATE]) // templates
            ->or('action', $this->resource_types_reversed[ResourceType::SNIPPET]) // snippets
            ->or('action', $this->resource_types_reversed[ResourceType::TV]) // tmplvars
            ->execute()
            ->asArray();
        $l = [];
        foreach ($locks as $lock) {
                $l[] = ($this->getLockedResourceName($lock->action, $lock->id));
        }
        return $l;
    }

    public function unlock()
    {
        return $this->connection->deleteQuery()
            ->table('modx_active_users')
            ->where('internalKey', '>', 0)
            ->execute()->get();
    }
}
