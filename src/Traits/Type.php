<?php

namespace SwaggerBuilder\Traits;

use SwaggerBuilder\Constants\Type as SwaggerTypes;

trait Type
{
    /**
     * @param string $type
     * @return static
     */
    public function setType(string $type = SwaggerTypes::STRING)
    {
        return $this->set('type', $type);
    }
}
