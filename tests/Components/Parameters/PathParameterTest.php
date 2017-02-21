<?php

namespace Tests\Components\Parameters;

use SwagBag\Components\Parameters\Parameter;
use SwagBag\Components\Parameters\PathParameter;
use SwagBag\Constants\Type;
use Tests\TestCase;

class PathParameterTest extends TestCase
{
    public function testItCompilesDefaults()
    {
        $expected = [
            'name' => 'id',
            'in' => Parameter::PATH,
            'type' => Type::INTEGER,
            'required' => true,
        ];

        $schema = new PathParameter($expected['name'], $expected['type']);

        static::assertComponentStructure($expected, $schema);
    }
}

