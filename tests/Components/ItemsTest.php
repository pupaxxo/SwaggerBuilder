<?php

namespace Tests\Components;

use SwaggerBuilder\Components\Items;
use SwaggerBuilder\Constants\SchemaType;
use SwaggerBuilder\Constants\Type;
use Tests\TestCase;

class ItemsTest extends TestCase
{
    public function testItCompilesDefaults()
    {
        $expected = [
            'type' => Type::STRING,
        ];

        $items = new Items($expected['type']);

        static::assertComponentStructure($expected, $items);
    }

    public function testItCompilesEverything()
    {
        $expected = [
            'type' => SchemaType::ARRAY,
            'items' => $this->createMock(Items::class),
        ];

        $items = (new Items($expected['type']))
            ->setItems($expected['items']);

        static::assertComponentStructure($expected, $items);
    }
}

