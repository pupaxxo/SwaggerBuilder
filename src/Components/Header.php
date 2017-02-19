<?php

namespace SwagBag\Components;

use SwagBag\Type;

class Header extends Component
{
    private $name;

    public function __construct(string $name = 'Content-Type', string $type = Type::STRING)
    {
        $this->name = $name;
        $this->setType($type);
    }

    private function setType(string $type): Header
    {
        return $this->set('type', $type);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(string $description = 'A header returned with the response.'): Header
    {
        return $this->set('description', $description);
    }
}
