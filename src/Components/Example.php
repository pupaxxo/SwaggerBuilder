<?php

namespace SwagBag\Components;

use SwagBag\Constants\Mime;

class Example extends Component
{
    private $mime;

    public function __construct(string $mime = Mime::JSON, array $structure = null)
    {
        $this->mime = $mime;
        foreach ($structure as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function getMime(): string
    {
        return $this->mime;
    }
}
