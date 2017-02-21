<?php

namespace SwaggerBuilder\Components;

use SwaggerBuilder\Constants\Type as SwaggerTypes;
use SwaggerBuilder\Traits\Description;
use SwaggerBuilder\Traits\Enum;
use SwaggerBuilder\Traits\Items;
use SwaggerBuilder\Traits\Length;
use SwaggerBuilder\Traits\Pattern;
use SwaggerBuilder\Traits\Range;
use SwaggerBuilder\Traits\Type;

class Header extends Component
{
    use Description, Type, Items, Range, Length, Pattern, Enum;
    private $name;

    public function __construct(string $name = 'Content-Type', string $type = SwaggerTypes::STRING)
    {
        $this->name = $name;
        $this->setType($type);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
