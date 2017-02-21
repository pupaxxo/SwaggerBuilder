<?php

namespace SwagBag\Components\Params;

use SwagBag\Constants\ParamType;

class PathParameter extends BaseParameter
{
    const PATH = 'path';

    public function __construct($name = 'id', $type = ParamType::STRING)
    {
        parent::__construct($name, static::PATH, $type, true);
    }
}
