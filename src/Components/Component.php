<?php

namespace SwaggerBuilder\Components;

use JsonSerializable;

class Component implements JsonSerializable
{
    protected $structure = [];

    function jsonSerialize()
    {
        return $this->structure;
    }

    protected function add(string $key, $value): Component
    {
        $keys = explode('.', $key);
        $iterator = &$this->structure;
        foreach ($keys as $key) {
            if (!is_array($iterator[$key] ?? null)) {
                $iterator[$key] = [];
            }
            $iterator = &$iterator[$key];
        }
        $iterator[] = $value;
        return $this;
    }

    protected function set(string $key, $value): Component
    {
        $keys = explode('.', $key);
        $valueKey = array_pop($keys);
        $iterator = &$this->structure;
        foreach ($keys as $key) {
            if (!is_array($iterator[$key] ?? null)) {
                $iterator[$key] = [];
            }
            $iterator = &$iterator[$key];
        }
        $iterator[$valueKey] = $value;
        return $this;
    }
}
