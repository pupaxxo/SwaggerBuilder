<?php

namespace Tests\Traits;

use SwagBag\Components\Component;
use SwagBag\Traits\Range;
use Tests\TestCase;

class RangeTest extends TestCase
{
    public function testItCompilesEverything()
    {
        $expected = [
            'minimum' => 10,
            'exclusiveMinimum' => false,
            'maximum' => 100,
            'exclusiveMaximum' => true,
        ];

        $rangeMock = (new RangeMock())
            ->setMin($expected['minimum'], $expected['exclusiveMinimum'])
            ->setMax($expected['maximum'], $expected['exclusiveMaximum']);

        static::assertComponentStructure($expected, $rangeMock);
    }
}

class RangeMock extends Component
{
    use Range;
}
