<?php

namespace Tests\Components;

use SwagBag\Components\Info;
use SwagBag\Components\Path;
use SwagBag\Components\Swagger;
use SwagBag\Constants\Mime;
use SwagBag\Constants\Scheme;
use Tests\ArrayAssertions;
use Tests\TestCase;

class SwaggerTest extends TestCase
{
    use ArrayAssertions;

    public function testItRequiresAtLeastOnePath()
    {
        $this->itRequiresAtLeastOneThingTest(Swagger::class, Path::class);

        new Swagger('2.0', new Info(), []);
    }

    public function testItRequiresPathObjectsSpecifically()
    {
        $given = 'foobar';
        $this->itRequiresThingObjectsSpecificallyTest(Swagger::class, 'addPath', Path::class, gettype($given));

        new Swagger('2.0', new Info(), [$given]);
    }

    public function testItCompilesDefaults()
    {
        $uri = '/pets';

        $expected = [
            'swagger' => '2.0',
            'info' => new Info(),
            'paths' => [$uri => $this->mockPath($uri)],
        ];

        $swagger = new Swagger($expected['swagger'], $expected['info'], $expected['paths']);

        self::assertEquals($expected, (array)$swagger);
    }

    private function mockPath(string $uri): Path
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|Path $path */
        $path = $this->createMock(Path::class);
        $path
            ->method('getUri')
            ->willReturn($uri);

        return $path;
    }

    public function testItCompilesEverything()
    {
        $uri = '/pets';

        $expected = [
            'swagger' => '2.0',
            'info' => new Info(),
            'host' => 'petstore.swagger.io',
            'basePath' => '/v2',
            'produces' => [Mime::JSON],
            'consumes' => [Mime::JSON],
            'schemes' => [Scheme::HTTP],
            'paths' => [$uri => $this->mockPath($uri)],
        ];

        $swagger = (new Swagger($expected['swagger'], $expected['info'], $expected['paths']))
            ->setHost($expected['host'])
            ->setBasePath($expected['basePath']);
        foreach ($expected['consumes'] as $mime) {
            $swagger->addConsumedMime($mime);
        }
        foreach ($expected['produces'] as $mime) {
            $swagger->addProducedMime($mime);
        }
        foreach ($expected['schemes'] as $scheme) {
            $swagger->addScheme($scheme);
        }

        self::assertEquals($expected, (array)$swagger);
    }
}
