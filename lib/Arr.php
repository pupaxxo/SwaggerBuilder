<?php

namespace Lib;

class Arr
{
    public static function set(string $key, $value, array $container = []): array
    {
        list($keys, $valueKey) = static::breakKey($key);
        $end = &static::seekEnd($keys, $container);
        $end[$valueKey] = $value;
        return $container;
    }

    private static function breakKey(string $key): array
    {
        $keys = explode('.', $key);
        $valueKey = array_pop($keys);
        return [$keys, $valueKey];
    }

    private static function &seekEnd(array $keys = [], array &$container = [])
    {
        $currentDepth = &$container;

        foreach ($keys as $key) {
            if (!is_array($currentDepth[$key] ?? null)) {
                $currentDepth[$key] = [];
            }
            $currentDepth = &$currentDepth[$key];
        }

        return $currentDepth;
    }

    public static function append(string $key, $value, array $container = []): array
    {
        list($keys, $valueKey) = static::breakKey($key);
        $end = &static::seekEnd($keys, $container);
        if (is_array($end[$valueKey] ?? null)) {
            $end[$valueKey][] = $value;
        } else {
            $end[$valueKey] = [$value];
        }
        return $container;
    }
}
