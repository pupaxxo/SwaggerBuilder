<?php

namespace SwagBag\Components;

use SwagBag\Constants\Mime;

class Example extends Component
{
    private $mime;

    public function __construct(string $mime = Mime::JSON, array $structure = [])
    {
        $this->mime = $mime;
        foreach ($structure as $key => $value) {
            $this[$key] = $value;
        }
    }

    public function getMime(): string
    {
        return $this->mime;
    }
}
