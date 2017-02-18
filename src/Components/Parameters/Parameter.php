<?php

namespace SwagBag\Components\Parameters;

use LogicException;
use SwagBag\Components\Component;
use SwagBag\Traits\Patterned;

abstract class Parameter extends Component
{
    use Patterned;

    const IN = '';

    private $name;

    public function __construct(string $name = 'query', bool $required = false)
    {
        $this->name = $name;
        if (!static::IN) {
            throw new LogicException("{$name} parameter missing 'IN' property.");
        }
        $this
            ->setName($name)
            ->setRequired($required)
            ->setIn(static::IN);
    }

    private function setIn(string $in): Parameter
    {
        return $this->set('in', $in);
    }

    private function setRequired(bool $required): Parameter
    {
        return $this->set('required', $required);
    }

    private function setName(string $name = 'filter'): Parameter
    {
        return $this->set('name', $name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(string $description = 'Data passed by the client.'): Parameter
    {
        return $this->set('description', $description);
    }
}
