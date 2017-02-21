<?php

namespace SwaggerBuilder\Traits;

use SwaggerBuilder\Components\Schema;

trait Items
{
    /**
     * @param Schema $items
     * @return static
     */
    public function setItems(Schema $items)
    {
        return $this->set('items', $items);
    }

    /**
     * @param int $maxItems
     * @return static
     */
    public function setMaxItems(int $maxItems = 99)
    {
        return $this->set('maxItems', $maxItems);
    }

    /**
     * @param int $minItems
     * @return static
     */
    public function setMinItems(int $minItems = 0)
    {
        return $this->set('maxItems', $minItems);
    }

    /**
     * @param bool $unique
     * @return static
     */
    public function setUniqueItems(bool $unique = true)
    {
        return $this->set('uniqueItems', $unique);
    }
}
