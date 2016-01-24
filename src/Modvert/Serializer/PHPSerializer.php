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
        $doc_block = $content = '';
        foreach ($tokens as $token) {
            if (T_DOC_COMMENT == $token[0]) {
                $doc_block = $token[1];
                $content = str_replace($doc_block, '', $source);
                $content = preg_replace("/\\r\\n/", "\n", $content);
                $content = preg_replace('/\<\?php[\r\n]?(.*)/sm', '${1}', $content);
                $content = preg_replace('/^\s+$/s', "\n", $content);
                $content = preg_replace('/^(\r*\n)$/m', '', $content, 1);
                break;
            }
        }
        $doc_block = preg_replace('/\/\*\*(.*)\*\//s', '${1}', $doc_block);
        $data = eval($doc_block);
        if ($content) {
            if ($content[0] == "\n" || $content[0] == "\r\n") {
                $content = preg_replace("/^\n/", "", $content, 1);
            }
        }
        $data['content'] = $content;
        return $data;
    }
}
