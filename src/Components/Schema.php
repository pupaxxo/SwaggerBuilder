<?php

namespace SwaggerBuilder\Components;

use SwaggerBuilder\Constants\Type;
use SwaggerBuilder\Traits\Description;
use SwaggerBuilder\Traits\Enum;
use SwaggerBuilder\Traits\Format;
use SwaggerBuilder\Traits\Items;
use SwaggerBuilder\Traits\Length;
use SwaggerBuilder\Traits\Pattern;
use SwaggerBuilder\Traits\Range;
use SwaggerBuilder\Traits\Type as TypeSetter;

class Schema extends Component
{
    use Description, TypeSetter, Items, Format, Range, Length, Pattern, Enum;

    public function __construct(string $type = Type::OBJECT)
    {
        $this->setType($type);
    }

    public function setProperty(string $name, Schema $schema, bool $required = false): Schema
    {
        if ($required) {
            $this->add('required', $name);
        }
        return $this->set("properties.{$name}", $schema);
    }

    /**
     * @param mixed $example
     * @return Schema
     */
    public function setExample($example): Schema
    {
        return $this->set('example', $example);
    }

    /**
     * @param string[] $properties
     * @return Schema
     */
    public function setRequired(array $properties = []): Schema
    {
        return $this->set('required', $properties);
    }
}
