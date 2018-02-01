<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Jarzon\Cache;

class FileCacheTest extends TestCase
{
    public function testSaveCacheFile()
    {
        $cache = new Cache(['cache_folder' =>  __DIR__ . '/cache']);

        $cache->saveCacheFile('testFile', 'okay');

        $file = $cache->getFileLocation('testFile');

        $this->assertEquals(true, file_exists($file));

        $this->assertEquals('okay', $cache->getCacheFile('testFile'));

        unlink($file);
    }
}