<?php

namespace SwaggerBuilder\Traits;

trait Patterned
{
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
