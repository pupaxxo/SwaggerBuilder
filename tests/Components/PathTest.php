<?php

namespace Tests\Components;

use SwaggerBuilder\Components\Operation;
use SwaggerBuilder\Components\Params\PathParameter;
use SwaggerBuilder\Components\Path;
use SwaggerBuilder\Constants\Verb;
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

    public function testItStoresItsUri()
    {
        $method = Verb::POST;
        $uri = '/pets';
        $operations = [
            $method => $this->mockOperation($method),
        ];

        $path = new Path($uri, $operations);

        static::assertEquals($uri, $path->getUri());
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

    public function testItCompilesDefaults()
    {
        $method = Verb::POST;
        $uri = '/pets';
        $operations = [
            $method => $this->mockOperation($method),
        ];

        $path = new Path($uri, $operations);

        static::assertComponentStructure($operations, $path);
    }

    public function testItCompilesEverything()
    {
        $method = Verb::POST;
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

    private function mockParameter(): PathParameter
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|PathParameter $parameter */
        $parameter = $this->createMock(PathParameter::class);

        return $parameter;
    }
}
