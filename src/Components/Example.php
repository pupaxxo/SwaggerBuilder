<?php

namespace SwaggerBuilder\Components;

use SwaggerBuilder\Constants\Mime;

class Example extends Component
{
    private $mime;

    public function __construct(string $mime = Mime::APP_JSON, array $structure = null)
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
