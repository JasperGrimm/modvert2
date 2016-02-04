<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 2:11 AM
 */

namespace Modvert;


interface IStorage
{
    /**
     * Load resources all types from remote stage
     *
     * @return mixed
     */
    public function loadRemote($stage);

    /**
     * Load resources all types from local database
     *
     * @return mixed
     */
    public function loadLocal();

    /**
     * Send resources all type to remote stage
     * @return mixed
     */
    public function pushToRemote($stage);
}