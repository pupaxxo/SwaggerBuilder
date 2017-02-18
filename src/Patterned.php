<?php

namespace SwagBag;

trait Patterned
{
    use JsonStruct;

    /**
     * @param string $key
     * @param $value
     * @return static
     */
    public function setOther(string $key, string $value)
    {
        return $this->set("x-{$key}", $value);
    }
}
