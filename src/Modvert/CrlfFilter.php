<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/23/2016
 * Time: 4:49 PM
 */

namespace Modvert;

/**
 * Преобразование конца строки к LF для всех ОС
 *
 * Class CrlfFilter
 * @package Modvert
 */
class CrlfFilter extends \php_user_filter
{
    function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            // make sure the line endings aren't already CRLF
            $bucket->data = preg_replace("/\r\n/", "\n", $bucket->data);
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }
        return PSFS_PASS_ON;
    }
}