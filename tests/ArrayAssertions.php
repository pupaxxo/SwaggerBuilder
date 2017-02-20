<?php
namespace Tests;

use InvalidArgumentException;
use TypeError;

trait ArrayAssertions
{
    public function itRequiresAtLeastOneThingTest(string $class, string $collectionClass)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            '%s expects at least one %s be provided.',
            $class,
            $collectionClass
        ));
    }

    public function itRequiresThingObjectsSpecificallyTest(
        string $class,
        string $func,
        string $collectionClass,
        string $givenType
    ) {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage(sprintf(
            'Argument 1 passed to %s::%s() must be an instance of %s, %s given',
            $class,
            $func,
            $collectionClass,
            $givenType
        ));
    }
}
