<?php

namespace SwagBag\Traits;

trait Patterned
{
    use JsonStruct;

    /**
     * @param string $key
     * @param string $value
     * @return static
     */
    public function setOther(string $key, string $value)
    {
        return $this->set("x-{$key}", $value);
    }
}
