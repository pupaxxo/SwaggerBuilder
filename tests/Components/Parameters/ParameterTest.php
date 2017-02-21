<?php

namespace Tests\Components\Parameters;

use SwaggerBuilder\Components\Params\Parameter;
use SwaggerBuilder\Constants\Type;
use Tests\TestCase;

class ParameterTest extends TestCase
{
    public function testItCompilesDefaults()
    {
        $expected = [
            'name' => 'limit',
            'in' => Parameter::QUERY,
            'type' => Type::INTEGER,
            'required' => false,
        ];

        $schema = new Parameter($expected['name'], $expected['in'], $expected['type'], $expected['required']);

        static::assertComponentStructure($expected, $schema);
    }
}

