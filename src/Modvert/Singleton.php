<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 1:33 AM
 */

namespace Modvert;

abstract class Singleton
{
    protected function __construct()
    {
    }

    final private function __clone()
    {
    }

    final public static function getInstance()
    {
        static $instances  = [];
        $calledClass = get_called_class();
        if (!isset($instances[$calledClass]))
        {
            $instances[$calledClass] = new $calledClass();
        }
        return $instances[$calledClass];
    }
}