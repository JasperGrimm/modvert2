<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/8/2015
 * Time: 10:07 AM
 */

namespace Modvert;


use PHPixie\Database\Connection;

class History extends Singleton
{

    /**
     * @var Connection
     */
    protected $connection;

    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @param $branch
     */
    public function getLastSyncedRevision($branch)
    {
        $query = $this->connection->selectQuery()
            ->table('modvert_history')
            ->fields(['revision'])
            ->where('branch', $branch)
            ->orderDescendingBy('created')
            ->limit(1)
        ;
        $last_synced_revision = $query->execute()->current();
        return $last_synced_revision;
    }

}