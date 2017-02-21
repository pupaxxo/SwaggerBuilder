<?php

namespace Tests\Components;

use SwagBag\Components\Schema;
use SwagBag\Constants\SchemaType;
use Tests\TestCase;

class SchemaTest extends TestCase
{
    public function testItCompilesDefaults()
    {
        $expected = [
            'type' => SchemaType::OBJECT,
        ];

        $schema = new Schema($expected['type']);

        static::assertComponentStructure($expected, $schema);
    }

    public function testItCompilesSchemaSpecifics()
    {
        $expected = [
            'type' => SchemaType::OBJECT,
            'example' => [
                'type' => 'User',
                'id' => 42,
                'properties' => [
                    'name' => 'Doe',
                ],
            ],
            'required' => [
                'id',
            ],
            'properties' => [
                'id' => new Schema(SchemaType::NUMBER),
                'name' => new Schema(SchemaType::STRING),
            ],
        ];

        $schema = (new Schema($expected['type']))
            ->setExample($expected['example'])
            ->setProperty('id', $expected['properties']['id'], true)
            ->setProperty('name', $expected['properties']['name']);

        static::assertComponentStructure($expected, $schema);
    }
}

