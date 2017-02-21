<?php

namespace SwaggerBuilder\Components\Params;

use SwaggerBuilder\Constants\ParamType;

class PathParameter extends BaseParameter
{
    const PATH = 'path';

    public function __construct($name = 'id', $type = ParamType::STRING)
    {
        parent::__construct($name, static::PATH, $type, true);
    }
}
