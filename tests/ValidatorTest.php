<?php

namespace Tests;

use InvalidArgumentException;
use SwaggerBuilder\Validator;

class ValidatorTest extends TestCase
{
    public function testAssertsArrayNotEmpty()
    {
        $class = '\Foo';
        $collectionClass = '\Bar';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            '%s expects at least one %s be provided.',
            $class,
            $collectionClass
        ));

        Validator::assertNotEmpty([], $class, $collectionClass);
    }
}
