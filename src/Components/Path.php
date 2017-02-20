<?php

namespace SwagBag\Components;

use SwagBag\Traits\Parameters;
use SwagBag\Validator;

class Path extends Component
{
    use Parameters;

    private $uri;

    public function __construct(string $uri = '/', array $operations = [])
    {
        Validator::assertNotEmpty($operations, static::class, Operation::class);
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
