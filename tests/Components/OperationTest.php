<?php

namespace Tests\Components;

use InvalidArgumentException;
use SwagBag\Components\Operation;
use SwagBag\Components\Params\Parameter;
use SwagBag\Components\Response;
use SwagBag\Constants\Mime;
use SwagBag\Constants\Scheme;
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

    public function testItValidatesIdsAreUnique()
    {
        $i = 1;
        $id = 'bar';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Given operation id '{$id}' is already registered as the {$i}th operation.");

        (new Operation(Verb::GET, [$this->mockResponse()]))->setOperationId('foo');
        (new Operation(Verb::PUT, [$this->mockResponse()]))->setOperationId($id);
        (new Operation(Verb::POST, [$this->mockResponse()]))->setOperationId('fiz');
        (new Operation(Verb::DELETE, [$this->mockResponse()]))->setOperationId($id);
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
            'deprecated' => true,
            'consumes' => $consumes,
            'produces' => $produces,
            'parameters' => [
                $this->mockParameter(),
            ],
            'responses' => [
                $status => $this->mockResponse($status),
            ],
            'schemes' => [
                Scheme::HTTPS,
            ],
        ];

        $operation = (new Operation(Verb::POST, $expected['responses']))
            ->setSummary($expected['summary'])
            ->setDescription($expected['description'])
            ->setOperationId($expected['operationId'])
            ->setDeprecated();
        foreach ($expected['consumes'] as $mime) {
            $operation->addConsumedMime($mime);
        }
        foreach ($expected['produces'] as $mime) {
            $operation->addProducedMime($mime);
        }
        foreach ($expected['parameters'] as $parameter) {
            $operation->addParameter($parameter);
        }
        foreach ($expected['schemes'] as $scheme) {
            $operation->addScheme($scheme);
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
