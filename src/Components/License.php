<?php

namespace SwagBag\Components;

use SwagBag\Patterned;

class License extends Component
{
    use Patterned;

    public function __construct(string $name = 'ISC License Agreement')
    {
        $this->set('name', $name);
    }

    public function setUrl(string $url = 'www.my.org/license'): License
    {
        return $this->set('url', $url);
    }
}
