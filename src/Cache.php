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