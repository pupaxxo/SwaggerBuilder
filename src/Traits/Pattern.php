<?php

namespace SwagBag\Traits;

trait Pattern
{
    /**
     * @param string $pattern
     * @return static
     */
    public function setPattern(string $pattern = '/[a-zA-Z0-9]/')
    {
        return $this->set('pattern', $pattern);
    }
}
