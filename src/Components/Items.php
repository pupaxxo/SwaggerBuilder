<?php

namespace SwagBag\Components;

use SwagBag\Traits\Items as ItemsTrait;
use SwagBag\Type;

class Items extends Component
{
    use ItemsTrait;

    public function __construct(string $type = Type::STRING)
    {
        $this->set('type', $type);
    }
}
