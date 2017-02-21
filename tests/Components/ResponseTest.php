<?php

namespace Tests\Components;

use SwaggerBuilder\Components\Example;
use SwaggerBuilder\Components\Header;
use SwaggerBuilder\Components\Response;
use SwaggerBuilder\Components\Schema;
use SwaggerBuilder\Constants\Mime;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testItStoresItsCode()
    {
        $code = 200;
        $expected = [
            'description' => 'successful operation',
        ];

        $response = new Response($code, $expected['description']);

        static::assertEquals($code, $response->getCode());
    }

    public function testItCompilesDefaults()
    {
        $code = 200;
        $expected = [
            'description' => 'successful operation',
        ];

        $response = new Response($code, $expected['description']);

        static::assertComponentStructure($expected, $response);
    }

    public function testItCompilesEverything()
    {
        $code = 200;
        $rateLimit = 'X-Rate-Limit-Limit';
        $exampleMime = Mime::APP_JSON;
        $expected = [
            'description' => 'successful operation',
            'schema' => $this->createMock(Schema::class),
            'headers' => [
                $rateLimit => $this->mockHeader($rateLimit),
            ],
            'examples' => [
                $exampleMime => $this->mockExample($exampleMime),
            ],
        ];

        $response = (new Response($code, $expected['description']))
            ->setSchema($expected['schema']);
        foreach ($expected['headers'] as $header) {
            $response->addHeader($header);
        }
        foreach ($expected['examples'] as $example) {
            $response->addExample($example);
        }

        $expected['examples'][$exampleMime] = [null];

        static::assertComponentStructure($expected, $response);
    }

    private function mockHeader(string $name): Header
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|Header $header */
        $header = $this->createMock(Header::class);
        $header
            ->method('getName')
            ->willReturn($name);

        return $header;
    }

    private function mockExample(string $mime): Example
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|Example $example */
        $example = $this->createMock(Example::class);
        $example
            ->method('getMime')
            ->willReturn($mime);

        return $example;
    }
}

