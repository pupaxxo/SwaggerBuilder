<?php

namespace SwagBag\Components;

use ArrayObject;

class Component extends ArrayObject
{
    protected function add(string $key, $value): Component
    {
        $keys = explode('.', $key);
        $iterator = &$this;
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
        $iterator = &$this;
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
