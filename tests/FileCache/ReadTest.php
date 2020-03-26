<?php

declare(strict_types=1);

namespace Zanzara\Test\FileCache;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Zanzara\Bot;
use Zanzara\Config;
use Zanzara\Context;


/**
 * Read array in che filesystem cache written by WriteMiddleware
 */
class ReadTest extends TestCase
{
    public function testFileCache()
    {
        $config = new Config();
        $config->updateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Bot('test', $config);

        $bot->onCommand('start', function (Context $ctx) {

            $cache = new FilesystemAdapter();
            $object = $cache->getItem('key');
            $array = $object->get();

            $this->assertEquals(array("Peter" => "35", "Ben" => "37", "Joe" => "43"), $array);


        })->middleware(new WriteMiddleware());

        $bot->run();


    }
}