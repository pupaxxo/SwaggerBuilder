<?php

namespace Tests\Components;

use SwaggerBuilder\Components\Info;
use SwaggerBuilder\Components\Path;
use SwaggerBuilder\Components\Swagger;
use SwaggerBuilder\Constants\Mime;
use SwaggerBuilder\Constants\Scheme;
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
            'paths' => [$uri => $this->mockPath($uri)],
            'swagger' => '2.0',
            'info' => $this->createMock(Info::class),
        ];

        $swagger = new Swagger($expected['swagger'], $expected['info'], $expected['paths']);

        static::assertComponentStructure($expected, $swagger);
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
            'paths' => [$uri => $this->mockPath($uri)],
            'swagger' => '2.0',
            'info' => $this->createMock(Info::class),
            'host' => 'petstore.swagger.io',
            'basePath' => '/v2',
            'consumes' => [Mime::APP_JSON],
            'produces' => [Mime::APP_JSON],
            'schemes' => [Scheme::HTTP],
        ];

        $swagger = (new Swagger($expected['swagger'], $expected['info'], $expected['paths']))
            ->setHost($expected['host'])
            ->setBasePath($expected['basePath'])
            ->setConsumedMimes($expected['consumes'])
            ->setProducedMimes($expected['produces'])
            ->setSchemes($expected['schemes']);

        static::assertComponentStructure($expected, $swagger);
    }
}
