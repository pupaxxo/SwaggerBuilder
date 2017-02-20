<?php

namespace Tests\Components;

use SwagBag\Components\Contact;
use SwagBag\Components\Info;
use SwagBag\Components\License;
use Tests\TestCase;

class InfoTest extends TestCase
{
    public function testItCompilesDefaults()
    {
        $expected = [
            'title' => 'Swagger Petstore',
            'version' => '1.0.0',
        ];

        $info = new Info($expected['title'], $expected['version']);

        static::assertComponentStructure($expected, $info);
    }

    public function testItCompilesEverything()
    {
        $expected = [
            'title' => 'Swagger Petstore',
            'version' => '1.0.0',
            'description' => 'This is a sample server Petstore server.',
            'termsOfService' => 'http://helloreverb.com/terms/',
            'contact' => $this->createMock(Contact::class),
            'license' => $this->createMock(License::class),
        ];

        $info = (new Info($expected['title'], $expected['version']))
            ->setDescription($expected['description'])
            ->setTermsOfService($expected['termsOfService'])
            ->setContact($expected['contact'])
            ->setLicense($expected['license']);

        static::assertComponentStructure($expected, $info);
    }
}
