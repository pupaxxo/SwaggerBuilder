<?php

namespace SwaggerBuilder\Factories;

use BadMethodCallException;
use SwaggerBuilder\Components\Schema;
use SwaggerBuilder\Constants\Format;
use SwaggerBuilder\Constants\Type;

/**
 * @property Schema object
 * @property Schema integer
 * @property Schema string
 */
class SchemaFactory
{
    public function object(): Schema
    {
        return new Schema();
    }

    public function integer(string $format = Format::INTEGER): Schema
    {
        return (new Schema(Type::INTEGER))->setFormat($format);
    }

    public function string(): Schema
    {
        return new Schema(Type::STRING);
    }

    public function __get($name)
    {
        if (!method_exists($this, $name)) {
            throw new BadMethodCallException(sprintf(
                '%s has no way of building "%s".',
                static::class,
                $name
            ));
        }
        return call_user_func([$this, $name]);
    }
}
