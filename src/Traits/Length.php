<?php

namespace SwaggerBuilder\Traits;

trait Length
{
    /**
     * @param int $minLength
     * @return static
     */
    public function setMinLength(int $minLength = 0)
    {
        return $this->set('minLength', $minLength);
    }

    /**
     * @param int $maxLength
     * @return static
     */
    public function setMaxLength(int $maxLength = 144)
    {
        return $this->set('maxLength', $maxLength);
    }
}
