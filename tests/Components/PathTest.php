<?php

namespace Tests\Components;

use SwagBag\Components\Operation;
use SwagBag\Components\Params\Parameter;
use SwagBag\Components\Path;
use SwagBag\Constants\Verb;
use Tests\ArrayAssertions;
use Tests\TestCase;

class PathTest extends TestCase
{
    use ArrayAssertions;

    public function testItRequiresAtLeastOneOperation()
    {
        $this->itRequiresAtLeastOneThingTest(Path::class, Operation::class);

        new Path('/pets', []);
    }

    public function testItRequiresOperationObjectsSpecifically()
    {
        $given = 'foobar';
        $this->itRequiresThingObjectsSpecificallyTest(Path::class, 'setOperation', Operation::class, gettype($given));

        new Path('/pets', [$given]);
    }

    public function testItCompilesDefaults()
    {
        $method = Verb::GET;
        $uri = '/pets';
        $operations = [
            $method => $this->mockOperation($method),
        ];

        $path = new Path($uri, $operations);

        static::assertComponentStructure($operations, $path);
    }

    private function mockOperation(string $method = Verb::GET): Operation
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|Operation $operation */
        $operation = $this->createMock(Operation::class);
        $operation
            ->method('getMethod')
            ->willReturn($method);

        return $operation;
    }

    public function testItStoresItsUri()
    {
        $method = Verb::GET;
        $uri = '/pets';
        $operations = [
            $method => $this->mockOperation($method),
        ];

        $path = new Path($uri, $operations);

        static::assertEquals($uri, $path->getUri());
    }

    public function testItCompilesEverything()
    {
        $method = Verb::GET;
        $uri = '/pets';
        $operations = [
            $method => $this->mockOperation($method),
        ];
        $expected = array_merge($operations, [
            'parameters' => [
                $this->mockParameter(),
            ],
        ]);

        $path = new Path($uri, $operations);
        foreach ($expected['parameters'] as $parameter) {
            $path->addParameter($parameter);
        }

        static::assertComponentStructure($expected, $path);
    }

    private function mockParameter(): Parameter
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|Parameter $parameter */
        $parameter = $this->createMock(Parameter::class);

        return $parameter;
    }
}
