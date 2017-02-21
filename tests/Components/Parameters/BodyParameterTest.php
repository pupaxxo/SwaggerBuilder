<?php

namespace Tests\Components\Parameters;

use SwagBag\Components\Parameters\BodyParameter;
use SwagBag\Components\Parameters\Parameter;
use SwagBag\Components\Schema;
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

