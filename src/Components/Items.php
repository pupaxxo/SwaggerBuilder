<?php

namespace SwagBag\Components;

use SwagBag\Constants\Type as SwaggerTypes;
use SwagBag\Traits\Enum;
use SwagBag\Traits\Items as ItemsTrait;
use SwagBag\Traits\Length;
use SwagBag\Traits\Pattern;
use SwagBag\Traits\Range;
use SwagBag\Traits\Type;

class Items extends Component
{
    use ItemsTrait, Type, Range, Length, Pattern, Enum;

    public function __construct(string $type = SwaggerTypes::STRING)
    {
        $this->setType($type);
    }
}
