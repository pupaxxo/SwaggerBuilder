<?php

namespace SwagBag\Components;

class Parameter extends Component
{
    private $name;

    public function __construct(string $name = 'query')
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
