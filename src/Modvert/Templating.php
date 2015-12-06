<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 10:56 AM
 */

namespace Modvert;


class Templating
{
    public static function render($path, $data)
    {
        $twig = new \Twig_Environment(
            new \Twig_Loader_Filesystem([__DIR__ . '/../../resources/templates']),
            ['auto_reload' => false, 'debug'=>false]
        );
        return $twig->render($path, $data);
    }
}