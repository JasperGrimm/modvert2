<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 12/5/2015
 * Time: 10:27 AM
 */

namespace Modvert\Filesystem;


use Modvert\Resource\IResource;
use Modvert\Serializer\ISerializer;
use Modvert\StringUtil;

class ResourceWriter implements IResourceWriter
{

    /**
     * @var ISerializer
     */
    protected $serializer;

    /**
     * CategoryWriter constructor.
     * @param $serializer
     */
    public function __construct(ISerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    private function save($path, $content) {
        // register the filter
        stream_filter_register('crlf', '\Modvert\CrlfFilter');
        $content = StringUtil::toUnix($content);
        $f = fopen($path, 'wt');
        // attach filter to output file
        stream_filter_append($f, 'crlf');
        // start writing
        fwrite($f, $content);
        fclose($f);
    }

    public function write(IResource $resource)
    {
        $content = $this->serializer->serialize($resource);
        $path = TARGET_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $resource->getType();
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            sleep(1);
        }
        $file_path = $path . DIRECTORY_SEPARATOR . StringUtil::transliterate($resource->getName()). '.model';
        if (!$this->save($file_path, $content)) {
            @mkdir($path, 0777, true);
            sleep(1);
            $this->save($file_path, $content);
        }
    }
}
