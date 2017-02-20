<?php

namespace SwagBag;

use InvalidArgumentException;

class Validator
{
    public static function assertNotEmpty(array $array, string $class, string $expected)
    {
        if (empty($array)) {
            throw new InvalidArgumentException(sprintf(
                '%s expects at least one %s be provided.',
                $class,
                $expected
            ));
        }
    }
}
