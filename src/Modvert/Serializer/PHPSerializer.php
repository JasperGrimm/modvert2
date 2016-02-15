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

class PHPSerializer extends Serializer
{

    /**
     * @param IResource $resource
     * @return string
     */
    public function serialize(IResource $resource)
    {
        $snippet = $resource->getCleanFields()['snippet'];
        $snippet = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*$/", "\n", $snippet); // remove empty lines from the end
        //$snippet = preg_replace("/\r\n/", "\n", $snippet); // remove empty lines from the end
        $snippet = preg_replace('/^\s+$/s', "\n", $snippet);
        $content = Templating::render('php.html.twig', [
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
        foreach ($tokens as $token) {
            if (T_DOC_COMMENT == $token[0]) {
                $docblock = $token[1];
                $content = str_replace($docblock, '', $source);
                $content = preg_replace("/\\r\\n/", "\n", $content);
                $content = preg_replace('/\<\?php[\r\n]?(.*)/sm', '${1}', $content);
                $content = preg_replace('/^\s+$/s', "\n", $content);
                $content = preg_replace('/^(\r*\n)$/m', '', $content, 1);
                break;
            }
        }
        $docblock = preg_replace('/\/\*\*(.*)\*\//s', '${1}', $docblock);
        $docblock = preg_replace('/^ *\*+/sm', '', $docblock);
        $data = eval($docblock);
        if ($content) {
            if ($content[0] == "\n" || $content[0] == "\r\n") {
                $content = preg_replace("/^\n/", "", $content, 1);
            }
        }
        $data['content'] = $content;
        return $data;
    }
}
