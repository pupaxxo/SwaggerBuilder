<?php

namespace SwaggerBuilder\Components\Params;

use SwaggerBuilder\Constants\Type;

class PathParameter extends BaseParameter
{
    const PATH = 'path';

    public function __construct($name = 'id', $type = Type::STRING)
    {
        parent::__construct($name, static::PATH, $type, true);
    }
}
