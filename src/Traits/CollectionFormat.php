<?php

namespace SwagBag\Traits;

use SwagBag\Constants\Format;

trait CollectionFormat
{
    /**
     * @param string $collectionFormat
     * @return static
     */
    public function setCollectionFormat(string $collectionFormat = Format::CSV)
    {
        return $this->set('collectionFormat', $collectionFormat);
    }
}
