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
        $version = '2.0';
        $info = new Info();
        $path = new Path();
        $swagger = new Swagger($version, $info, [$path]);

        self::assertEquals([
            'swagger' => $version,
            'info' => $info,
            'paths' => ['/' => $path],
        ], (array)$swagger);
    }

    public function testItCompilesEverything()
    {
        $version = '2.0';
        $info = new Info();
        $host = 'localhost';
        $basePath = '/test';
        $schemes = [Scheme::HTTPS];
        $consumes = [Mime::JSON];
        $produces = [Mime::JSON];
        $path = new Path();
        $swagger = (new Swagger($version, $info, [$path]))
            ->setHost($host)
            ->setBasePath($basePath);
        foreach ($consumes as $mime) {
            $swagger->addConsumedMime($mime);
        }
        foreach ($produces as $mime) {
            $swagger->addProducedMime($mime);
        }
        foreach ($schemes as $scheme) {
            $swagger->addScheme($scheme);
        }

        self::assertEquals([
            'swagger' => $version,
            'info' => $info,
            'host' => $host,
            'basePath' => $basePath,
            'produces' => $produces,
            'consumes' => $consumes,
            'schemes' => $schemes,
            'paths' => [$path->getUri() => $path],
        ], (array)$swagger);
    }
}
