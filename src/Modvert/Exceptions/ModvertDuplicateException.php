<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 4:15 AM
 */

namespace Modvert\Exceptions;


class ModvertDuplicateException extends \Exception
{
    protected $message = 'Modx resource have duplicate in the storage. Run `modvert.cli.php fix-duplicates` to resolve manually';
}