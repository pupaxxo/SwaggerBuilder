<?php

namespace Tests\Components;

use SwaggerBuilder\Components\Contact;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function testItCompilesDefaults()
    {
        $expected = [];

        $contact = new Contact();

        static::assertComponentStructure($expected, $contact);
    }

    public function testItCompilesEverything()
    {
        $expected = [
            'name' => 'apiteam',
            'url' => 'http://www.swagger.io',
            'email' => 'apiteam@swagger.io',
            'x-auxiliary' => 'aux',
        ];

        $contact = (new Contact())
            ->setName($expected['name'])
            ->setUrl($expected['url'])
            ->setEmail($expected['email'])
            ->setOther('auxiliary', $expected['x-auxiliary']);

        static::assertComponentStructure($expected, $contact);
    }
}
