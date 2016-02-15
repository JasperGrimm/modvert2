<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 16.09.15
 * Time: 0:48
 */

namespace Modvert\Serializer;

use Modvert\Resource\IResource;
use Modvert\Templating;

class HTMLSerializer extends Serializer
{

    public function serialize(IResource $resource)
    {
        $content = Templating::render('raw.html.twig', [
            'comment_data' => $resource->getStringInfo(),
            'content' => $resource->getContent()
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
                $empty1 = <<<'empty'
<?php

?>

empty;
                $content = str_replace($empty1, '', $content);
                if (preg_match('/\<\?php(\\r\\n|\\n)*\?\>(\\r\\n|\\n)*(.*)/s', $content, $m)) {
                    if ($m && count($m)) {
                        $content = preg_replace('/\<\?php(\\r\\n|\\n)*\?\>(\\r\\n|\\n)*(.*)/s', '${3}', $content);
                    }
                }
                break;
            }
        }
        $docblock = preg_replace('/\/\*\*(.*)\*\//s', '${1}', $docblock);
        $docblock = preg_replace('/^ *\*+/sm', '', $docblock);
        $data = eval($docblock);
        $data['content'] = $content;
        return $data;
    }

}