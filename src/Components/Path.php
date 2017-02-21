<?php

namespace SwagBag\Components;

use SwagBag\Components\Parameters\PathParameter;
use SwagBag\Traits\Parameters;
use SwagBag\Validator;

class Path extends Component
{
    use Parameters {
        Parameters::addParameter as private doAddParameter;
    }

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

    public function addParameter(PathParameter $parameter)
    {
        return $this->doAddParameter($parameter);
    }
}
