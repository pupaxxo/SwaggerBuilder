<?php

namespace Tests\Components;

use InvalidArgumentException;
use SwagBag\Components\Info;
use SwagBag\Components\Path;
use SwagBag\Components\Swagger;
use SwagBag\Constants\Mime;
use SwagBag\Constants\Scheme;
use Tests\TestCase;
use TypeError;

class SwaggerTest extends TestCase
{
    public function testItRequiresAtLeastOnePath()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('At least one path must be specified.');

        new Swagger('2.0', new Info(), []);
    }

    public function testItRequiresPathObjectsSpecifically()
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage(sprintf(
            'Argument 1 passed to %s::addPath() must be an instance of %s, %s given',
            Swagger::class,
            Path::class,
            'string'
        ));

        new Swagger('2.0', new Info(), ['foobar']);
    }

    public function testItCompilesDefaults()
    {
        $path = new Path();
        $expected = [
            'swagger' => '2.0',
            'info' => new Info(),
            'paths' => [$path->getUri() => $path],
        ];

        $swagger = new Swagger($expected['swagger'], $expected['info'], $expected['paths']);

        self::assertEquals($expected, (array)$swagger);
    }

    public function testItCompilesEverything()
    {
        $path = new Path();
        $expected = [
            'swagger' => '2.0',
            'info' => new Info(),
            'host' => 'petstore.swagger.io',
            'basePath' => '/v2',
            'produces' => [Mime::JSON],
            'consumes' => [Mime::JSON],
            'schemes' => [Scheme::HTTP],
            'paths' => [$path->getUri() => $path],
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
