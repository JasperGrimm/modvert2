<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 10/09/15
 * Time: 02:27
 */

namespace Qst\Serializer;


use Diff;
use Qst\App;
use Qst\ResourceModel;
use Qst\IModxResource;

abstract class Serializer
{

    public function writeFile($path, $content)
    {
        return file_put_contents($path, $content);
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
                break;
            }
        }
        $docblock = preg_replace('/\/\*\*(.*)\*\//s', '${1}', $docblock);
        $data = eval($docblock);
        $data['content'] = $content;
        return $data;
    }

    public static function cleanContent($content)
    {
//        $content = preg_replace('/^\\n*(.*)$/s', '${1}', $content);
        return $content;
    }

    public function isChanged(ResourceModel $object)
    {
        if (!$object) return true;
        $file = $object->getBoundFile();
        if (!file_exists($file) || !$object) return true;
        $data1 = $object->toArray();
        switch($object->getType()) {
            case IModxResource::TYPE_SNIPPET:
                $object2 = new Snippet();
                break;
            case IModxResource::TYPE_CHUNK:
                $object2 = new Chunk();
                break;
            case IModxResource::TYPE_CONTENT:
                $object2 = new Content();
                break;
            case IModxResource::TYPE_TEMPLATE:
                $object2 = new Template();
                break;
            case IModxResource::TYPE_TEMPLVAR:
                $object2 = new TV();
                break;
            default:
                return false;
        }

        $object2->loadFromFile($file);

        $data2 = $object2->toArray();
        if (in_array('description', array_keys($data1)) && in_array('description', array_keys($data2))) {
            unset($data1['description']);
            unset($data2['description']);
        }
        $contentDiff = false;
        if (in_array($object->getType(), [IModxResource::TYPE_SNIPPET, IModxResource::TYPE_CHUNK])) {
            $snippet1 = self::cleanContent($data1['snippet']);
            $snippet2 = self::cleanContent($data2['snippet']);
            unset($data1['snippet'], $data2['snippet']);
            $a = explode("\n", $snippet1);
            $b = explode("\n", $snippet2);
            $d = new Diff($a, $b, []);
            $renderer = new \Diff_Renderer_Html_SideBySide;
            $diffc = $d->render($renderer);
            $this->diff = $diffc;
            $contentDiff = !empty($diffc);
//            Log::info($diffc);
        }
        $changed = (strcmp(json_encode($data1), json_encode($data1)) !== 0) || $contentDiff;
        //if ($changed) Log::info($object->getType() . ':' . $object->getName() . '  ' . var_export($diff, 1));
        return $changed;
    }
}