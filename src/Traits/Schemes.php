<?php

namespace SwagBag\Traits;

use SwagBag\Scheme;

trait Schemes
{
    use JsonStruct;

    public function addScheme(string $scheme = Scheme::HTTP)
    {
        return $this->add('schemes', $scheme);
    }
}
