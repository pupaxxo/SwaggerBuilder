<?php

namespace SwagBag\Traits;

use SwagBag\Components\Items as ItemsComponent;

trait Items
{
    /**
     * @param ItemsComponent $items
     * @return static
     */
    public function setItems(ItemsComponent $items)
    {
        return $this->set('items', $items);
    }
}
