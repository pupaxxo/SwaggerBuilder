<?php

namespace SwagBag\Components;

use SwagBag\Traits\Parameters;

class Path extends Component
{
    use Parameters;

    private $uri;

    public function __construct(string $uri = '/', array $operations = [])
    {
        $this->uri = $uri;
        foreach ($operations as $operation) {
            $this->setOperation($operation);
        }
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
