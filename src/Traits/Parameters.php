<?php

namespace SwagBag\Traits;

use SwagBag\Components\Parameters\Parameter;

trait Parameters
{
    use JsonStruct;

    public function addParameter(Parameter $parameter)
    {
        return $this->append("parameters", $parameter);
    }
}
