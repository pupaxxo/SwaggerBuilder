<?php

namespace SwagBag\Components;

use SwagBag\Constants\SchemaType;
use SwagBag\Traits\Description;
use SwagBag\Traits\Enum;
use SwagBag\Traits\Format;
use SwagBag\Traits\Items;
use SwagBag\Traits\Length;
use SwagBag\Traits\Pattern;
use SwagBag\Traits\Range;
use SwagBag\Traits\Type;

class Schema extends Component
{
    use Description, Type, Items, Format, Range, Length, Pattern, Enum;

    public function __construct(string $type = SchemaType::OBJECT)
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
