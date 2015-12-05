<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 16.09.15
 * Time: 0:48
 */

namespace Modvert\Serializer;

use Modvert\Resource\IResource;

class PHPSerializer extends Serializer
{

    public function serialize(IResource $resource)
    {
        $snippet = $resource->getCleanFields()['snippet'];
        $content = App::render('php.html.twig', [
            'comment_data' => $resource->getStringInfo(),
            'content' => $snippet
        ]);
        return $content;
    }

    public function deserialize($path)
    {
        $source = file_get_contents($path);
        $tokens = token_get_all($source);
        $docblock = $content = '';
        foreach( $tokens as $token ) {
            if (T_DOC_COMMENT == $token[0]) {
                $docblock = $token[1];
                $content = str_replace($docblock, '', $source);
                $content = preg_replace('/\\r\\n/s', "\n", $content);
                $content = preg_replace('/\<\?php(\\n\\n)(.*)/sm', '${2}', $content);
                $content = preg_replace('/(.*)\?\>/sm', '${1}', $content);
                break;
            }
        }
        $docblock = preg_replace('/\/\*\*(.*)\*\//s', '${1}', $docblock);
        $data = eval($docblock);
        $data['content'] = $content;
        return $data;
    }
}