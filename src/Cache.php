<?php
namespace Jarzon;

class Cache
{
    protected $options = [];

    public function __construct(array $options = [])
    {
        $this->options = $options += [
            'cache_folder' => ''
        ];
    }

    public function registerCache($name, int $timeToLive, callable $callback)
    {
        $timestamp = $this->cacheTimestamp($name);

        if($timestamp > 0 && (time() - $timestamp) < $timeToLive) {
            return $this->getCacheFile($name);
        } else {
            $result = $callback();
            $this->saveCacheFile($name, $result);

            return $result;
        }
    }

    public function cacheTimestamp(string $file) : int
    {
        $location = $this->getFileLocation($file);

        if(file_exists($location)) {
            return filemtime($location);
        }

        return 0;
    }

    public function saveCacheFile(string $file, $data)
    {
        $location = $this->getFileLocation($file);

        if(!file_exists($location)) {
            touch($location);
        }

        return file_put_contents($location, serialize($data));
    }

    public function getCacheFile(string $file)
    {
        $location = $this->getFileLocation($file);

        if(file_exists($location)) {
            return unserialize(file_get_contents($location));
        }

        return false;
    }

    public function getFileLocation(string $file) : string
    {
        return "{$this->options['cache_folder']}/$file";
    }
}