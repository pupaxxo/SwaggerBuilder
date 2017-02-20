<?php

namespace SwagBag\Components;

use SwagBag\Constants\Type;
use SwagBag\Traits\Items as ItemsTrait;

class Items extends Component
{
    use ItemsTrait;

    public function __construct(string $type = Type::STRING)
    {
        $this->set('type', $type);
    }
}
