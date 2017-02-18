<?php

namespace Lib;

class Arr
{
    public static function set(string $key, $value, array $container = []): array
    {
        $keys = explode('.', $key);
        $valueKey = array_pop($keys);
        return static::delve(function (array &$end, array &$container) use ($valueKey, $value) {
            $end[$valueKey] = $value;
            return $container;
        }, $keys, $container);
    }

    private static function delve(callable $cb, array $keys = [], array $container = [])
    {
        $currentDepth = &$container;

        foreach ($keys as $key) {
            if (!is_array($currentDepth[$key] ?? null)) {
                $currentDepth[$key] = [];
                $currentDepth = &$currentDepth[$key];
            }
        }

        return $cb($currentDepth, $container);
    }

    public static function append(string $key, $value, array $container = []): array
    {
        $keys = explode('.', $key);
        $valueKey = array_pop($keys);
        return static::delve(function (&$end, &$container) use ($valueKey, $value) {
            if (is_array($end[$valueKey] ?? null)) {
                $end[$valueKey][] = $value;
            } else {
                $end[$valueKey] = [$value];
            }
            return $container;
        }, $keys, $container);
    }
}
