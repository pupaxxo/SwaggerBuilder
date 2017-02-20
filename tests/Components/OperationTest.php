<?php

namespace Tests\Components;

use SwagBag\Components\Operation;
use SwagBag\Components\Params\Parameter;
use SwagBag\Components\Response;
use SwagBag\Constants\Mime;
use SwagBag\Constants\Verb;
use Tests\ArrayAssertions;
use Tests\TestCase;

class OperationTest extends TestCase
{
    use ArrayAssertions;

    public function testItRequiresAtLeastOneResponse()
    {
        $this->itRequiresAtLeastOneThingTest(Operation::class, Response::class);

        new Operation(Verb::POST, []);
    }

    public function testItRequiresResponseObjectsSpecifically()
    {
        $given = 'foobar';
        $this->itRequiresThingObjectsSpecificallyTest(
            Operation::class,
            'addResponse',
            Response::class,
            gettype($given)
        );

        new Operation(Verb::POST, [$given]);
    }

    public function testItStoresItsMethod()
    {
        $method = Verb::GET;
        $status = 200;
        $responses = [
            $status => $this->mockResponse($status),
        ];

        $operation = new Operation($method, $responses);

        static::assertEquals($method, $operation->getMethod());
    }

    private function mockResponse(int $code = 200): Response
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|Response $response */
        $response = $this->createMock(Response::class);
        $response
            ->method('getCode')
            ->willReturn($code);

        return $response;
    }

    public function testItCompilesDefaults()
    {
        $status = 200;
        $expected = [
            'responses' => [
                $status => $this->mockResponse($status),
            ],
        ];

        $operation = new Operation(Verb::POST, $expected['responses']);

        static::assertComponentStructure($expected, $operation);
    }

    public function testItCompilesEverything()
    {
        $status = 200;
        $consumes = [Mime::JSON];
        $produces = [Mime::JSON];
        $expected = [
            'summary' => 'Add a new pet to the store',
            'description' => 'Store some pet data in a database somewhere.',
            'operationId' => 'addPet',
            'consumes' => $consumes,
            'produces' => $produces,
            'parameters' => [
                $this->mockParameter(),
            ],
            'responses' => [
                $status => $this->mockResponse($status),
            ],
        ];

        $operation = (new Operation(Verb::POST, $expected['responses']))
            ->setSummary($expected['summary'])
            ->setDescription($expected['description'])
            ->setOperationId($expected['operationId']);
        foreach ($expected['consumes'] as $mime) {
            $operation->addConsumedMime($mime);
        }
        foreach ($expected['produces'] as $mime) {
            $operation->addProducedMime($mime);
        }
        foreach ($expected['parameters'] as $parameter) {
            $operation->addParameter($parameter);
        }

        static::assertComponentStructure($expected, $operation);
    }

    private function mockParameter(): Parameter
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|Parameter $parameter */
        $parameter = $this->createMock(Parameter::class);

        return $parameter;
    }
}
