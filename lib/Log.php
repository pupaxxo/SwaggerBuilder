<?php

namespace Lib;

class Log
{
    public static function dd(...$args)
    {
        static::d(...$args);
        die();
    }

    public static function d(...$args)
    {
        var_dump(...$args);
    }
}
