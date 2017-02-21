<?php

namespace SwagBag\Traits;

trait Range
{
    /**
     * @param integer|float $minimum
     * @param bool $exclusive
     * @return static
     */
    public function setMin($minimum, bool $exclusive = false)
    {
        return $this
            ->set('minimum', $minimum)
            ->set('exclusiveMinimum', $exclusive);
    }

    /**
     * @param integer|float $maximum
     * @param bool $exclusive
     * @return static
     */
    public function setMax($maximum, bool $exclusive = false)
    {
        return $this
            ->set('maximum', $maximum)
            ->set('exclusiveMinimum', $exclusive);
    }
}
