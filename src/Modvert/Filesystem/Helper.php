<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 10:14 PM
 */

namespace Modvert\Filesystem;


class Helper
{

    public static function delTree($dir, $ignore=[]) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if (!in_array($file, ['.','..']) && !in_array($file, $ignore)) {
                    self::delTree("$dir/$file");
                }
            }
        } else {
            if (!in_array($dir, $ignore)) {
                unlink($dir);
            }
        }
    }

}