<?php

namespace Tests\Components\Parameters;

use SwaggerBuilder\Components\Params\BodyParameter;
use SwaggerBuilder\Components\Params\Parameter;
use SwaggerBuilder\Components\Schema;
use Tests\TestCase;

class BodyParameterTest extends TestCase
{
    public function testItCompilesDefaults()
    {
        $expected = [
            'name' => 'id',
            'in' => Parameter::BODY,
            'required' => true,
            'schema' => $this->createMock(Schema::class),
        ];

        $schema = new BodyParameter($expected['name'], $expected['required'], $expected['schema']);

        static::assertComponentStructure($expected, $schema);
    }
}

