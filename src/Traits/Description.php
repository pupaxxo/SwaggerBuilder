<?php

namespace SwagBag\Traits;

trait Description
{
    /**
     * @param string $description
     * @return static
     */
    public function setDescription(string $description = 'Some field.')
    {
        return $this->set('description', $description);
    }
}
