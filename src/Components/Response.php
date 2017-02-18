<?php

namespace SwagBag\Components;

class Response extends Component
{
    private $code;

    public function __construct(int $code = 200)
    {
        $this->code = $code;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
