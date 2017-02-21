<?php

namespace SwaggerBuilder\Traits;

use SwaggerBuilder\Constants\Format as FormatTypes;

trait Format
{
    /**
     * @param string $format
     * @return static
     */
    public function setFormat(string $format = FormatTypes::CSV)
    {
        return $this->set('format', $format);
    }
}
