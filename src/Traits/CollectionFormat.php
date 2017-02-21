<?php

namespace SwaggerBuilder\Traits;

use SwaggerBuilder\Constants\Format as FormatType;

trait CollectionFormat
{
    /**
     * @param string $collectionFormat
     * @return static
     */
    public function setCollectionFormat(string $collectionFormat = FormatType::CSV)
    {
        return $this->set('collectionFormat', $collectionFormat);
    }
}
