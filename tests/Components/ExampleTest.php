<?php

namespace Tests\Components;

use SwagBag\Components\Example;
use SwagBag\Constants\Mime;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testItStoresItsMime()
    {
        $mime = Mime::APP_JSON;
        $example = new Example($mime, []);

        static::assertEquals($mime, $example->getMime());
    }

    public function testItCompilesEverything()
    {
        $mime = Mime::APP_JSON;
        $expected = [
            'type' => 'User',
            'id' => 42,
            'attributes' => [
                'name' => 'John Doe',
                'email' => 'jd@example.com',
            ],
        ];

        $example = new Example($mime, $expected);

        static::assertComponentStructure($expected, $example);
    }
}

