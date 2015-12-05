<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 16.09.15
 * Time: 0:48
 */

namespace Modvert\Serializer;

use Modvert\Resource\Resource;

class HTMLSerializer extends Serializer
{

    public function serialize(Resource $resource)
    {
        $path = $this->serializedModelPath . $resource->getType() . '/' . $resource->getName() . '.model';
        if (!file_exists(dirname($path))) mkdir(dirname($path), 0777, true);
        $content = App::render('raw.html.twig', [
            'comment_data' => $resource->getStringInfo(),
            'content' => $resource->getContent()
        ]);
        $written = $this->writeFile($path, $content);
        return $written;
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
        $data = eval($docblock);
        $data['content'] = $content;
        return $data;
    }

}