<?php

namespace Tests\Components;

use SwagBag\Components\License;
use Tests\TestCase;

class LicenseTest extends TestCase
{
    public function testItCompilesDefaults()
    {
        $expected = [
            'name' => 'Apache 2.0',
        ];

        $license = new License($expected['name']);

        self::assertEquals($expected, (array)$license);
    }

    public function testItCompilesEverything()
    {
        $expected = [
            'name' => 'Apache 2.0',
            'url' => 'http://www.apache.org/licenses/LICENSE-2.0.html',
            'x-auxiliary' => 'aux',
        ];

        $license = (new License($expected['name']))
            ->setUrl($expected['url'])
            ->setOther('auxiliary', $expected['x-auxiliary']);

        self::assertEquals($expected, (array)$license);
    }
}
