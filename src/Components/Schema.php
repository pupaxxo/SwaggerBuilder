<?php

namespace SwagBag\Components;

use SwagBag\Constants\SchemaType;

class Schema extends Component
{
    public function __construct(string $type = SchemaType::OBJECT)
    {
        $this->setType($type);
    }

    private function setType(string $type): Schema
    {
        return $this->set('type', $type);
    }

    public function setProperty(string $name, Schema $schema): Schema
    {
        return $this->set("properties.{$name}", $schema);
    }

    public function setDescription(string $description): Schema
    {
        return $this->set('description', $description);
    }

    /**
     * @param mixed $example
     * @return Schema
     */
    public function setExample($example): Schema
    {
        return $this->set('example', $example);
    }
}
