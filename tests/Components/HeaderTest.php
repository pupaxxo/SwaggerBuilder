<?php

namespace Tests\Components;

use SwaggerBuilder\Components\Header;
use SwaggerBuilder\Constants\Type;
use Tests\TestCase;

class HeaderTest extends TestCase
{
    public function testItStoresItsName()
    {
        $name = 'X-Rate-Limit-Limit';
        $expected = [
            'type' => Type::INTEGER,
        ];

        $example = new Header($name, $expected['type']);

        static::assertEquals($name, $example->getName());
    }

    public function testItCompilesDefaults()
    {
        $name = 'X-Rate-Limit-Limit';
        $expected = [
            'type' => Type::INTEGER,
        ];

        $example = new Header($name, $expected['type']);

        static::assertComponentStructure($expected, $example);
    }

    public function testItCompilesEverything()
    {
        $name = 'X-Rate-Limit-Limit';
        $expected = [
            'type' => Type::INTEGER,
            'description' => 'The number of allowed requests in the current period.',
        ];

        $example = (new Header($name, $expected['type']))
            ->setDescription($expected['description']);

        static::assertComponentStructure($expected, $example);
    }
}

