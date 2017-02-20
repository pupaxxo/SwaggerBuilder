<?php

namespace SwagBag\Traits;

use SwagBag\Components\Params\Parameter;

trait Parameters
{
    /**
     * @param Parameter $parameter
     * @return static
     */
    public function addParameter(Parameter $parameter)
    {
        return $this->add("parameters", $parameter);
    }
}
