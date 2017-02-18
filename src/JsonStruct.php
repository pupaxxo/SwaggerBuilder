<?php

namespace SwagBag;

use Lib\Arr;

trait JsonStruct
{
    protected $structure = [];

    function jsonSerialize()
    {
        return $this->structure;
    }

    /**
     * @param string $key
     * @param $value
     * @return static
     */
    protected function append(string $key, $value)
    {
        $this->structure = Arr::append($key, $value, $this->structure);
        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return static
     */
    protected function set(string $key, $value)
    {
        $this->structure = Arr::set($key, $value, $this->structure);
        return $this;
    }
}
