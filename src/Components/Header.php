<?php

namespace SwagBag\Components;

use SwagBag\Constants\Type as SwaggerTypes;
use SwagBag\Traits\Description;
use SwagBag\Traits\Enum;
use SwagBag\Traits\Items;
use SwagBag\Traits\Length;
use SwagBag\Traits\Pattern;
use SwagBag\Traits\Range;
use SwagBag\Traits\Type;

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
