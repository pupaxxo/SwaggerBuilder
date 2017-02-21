<?php

namespace SwaggerBuilder\Components;

use SwaggerBuilder\Constants\Type as SwaggerTypes;
use SwaggerBuilder\Traits\CollectionFormat;
use SwaggerBuilder\Traits\Enum;
use SwaggerBuilder\Traits\Format;
use SwaggerBuilder\Traits\Items as ItemsTrait;
use SwaggerBuilder\Traits\Length;
use SwaggerBuilder\Traits\Pattern;
use SwaggerBuilder\Traits\Range;
use SwaggerBuilder\Traits\Type;

class Items extends Component
{
    use ItemsTrait, CollectionFormat, Format, Type, Range, Length, Pattern, Enum;

    public function __construct(string $type = SwaggerTypes::STRING)
    {
        $this->setType($type);
    }
}
