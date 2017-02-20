<?php

namespace SwagBag\Components;

use InvalidArgumentException;
use SwagBag\Traits\Parameters;

class Path extends Component
{
    use Parameters;

    private $uri;

    public function __construct(string $uri = '/', array $operations = [])
    {
        if (empty($operations)) {
            throw new InvalidArgumentException(sprintf(
                '%s expects at least one %s be provided.',
                static::class,
                Operation::class
            ));
        }
        foreach ($operations as $operation) {
            $this->setOperation($operation);
        }
        $this->uri = $uri;
    }

    private function setOperation(Operation $operation): Path
    {
        return $this->set($operation->getMethod(), $operation);
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
