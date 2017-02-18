<?php

namespace SwagBag\Traits;

trait Patterned
{
    use JsonStruct;

    public function setOther(string $key, string $value)
    {
        return $this->set("x-{$key}", $value);
    }
}
