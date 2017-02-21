<?php

namespace SwagBag\Traits;

use SwagBag\Components\Parameters\BaseParameter;

trait Parameters
{
    /**
     * @param BaseParameter $parameter
     * @return static
     */
    public function addParameter(BaseParameter $parameter)
    {
        return $this->add("parameters", $parameter);
    }
}
