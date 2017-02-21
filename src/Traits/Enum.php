<?php

namespace SwaggerBuilder\Traits;

trait Enum
{
    /**
     * @param mixed[] $enum
     * @return static
     */
    public function setEnum(array $enum = [])
    {
        return $this->set('enum', $enum);
    }
}
