<?php

namespace SwagBag\Components\Parameters;

use SwagBag\Components\Component;
use SwagBag\Constants\ParamType;
use SwagBag\Traits\Description;
use SwagBag\Traits\Enum;
use SwagBag\Traits\Items;
use SwagBag\Traits\Length;
use SwagBag\Traits\Pattern;
use SwagBag\Traits\Range;
use SwagBag\Traits\Type;

class Parameter extends Component
{
    use Description, Type, Items, Range, Length, Pattern, Enum;

    const QUERY = 'query';
    const HEADER = 'header';
    const FORM = 'formData';

    public function __construct(
        string $name = 'filter',
        string $in = self::QUERY,
        string $type = ParamType::STRING,
        bool $required = false
    ) {
        $this
            ->setName($name)
            ->setIn($in)
            ->setType($type)
            ->setRequired($required);
    }

    private function setRequired(bool $required): Parameter
    {
        return $this->set('required', $required);
    }

    private function setIn(string $in): Parameter
    {
        return $this->set('in', $in);
    }

    private function setName(string $name): Parameter
    {
        return $this->set('name', $name);
    }
}
