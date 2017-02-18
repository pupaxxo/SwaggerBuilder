<?php

namespace SwagBag\Components;

use JsonSerializable;
use SwagBag\Traits\JsonStruct;

class Component implements JsonSerializable
{
    use JsonStruct;

    function jsonSerialize()
    {
        return $this->structure;
    }
}
