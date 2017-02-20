<?php

namespace Tests;

use SwagBag\Components\Component;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public static function assertComponentStructure(array $expected = [], Component $component)
    {
        static::assertEquals(json_decode(json_encode($expected)), json_decode(json_encode($component)));
    }
}
