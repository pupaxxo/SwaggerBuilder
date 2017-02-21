<?php

namespace SwagBag\Components\Parameters;

use SwagBag\Constants\ParamType;

class PathParameter extends Parameter
{
    const PATH = 'path';

    public function __construct($name = 'id', $type = ParamType::STRING)
    {
        parent::__construct($name, static::PATH, $type, true);
    }
}
