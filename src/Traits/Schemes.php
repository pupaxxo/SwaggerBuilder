<?php

namespace SwagBag\Traits;

use SwagBag\Constants\Scheme;

trait Schemes
{
    use JsonStruct;

    /**
     * @param string $scheme
     * @return static
     */
    public function addScheme(string $scheme = Scheme::HTTP)
    {
        return $this->add('schemes', $scheme);
    }
}
