<?php

namespace SwagBag\Traits;

use SwagBag\Components\Component;
use SwagBag\Constants\Scheme;

trait Schemes
{
    /**
     * @param string[] $schemes
     * @return static
     */
    public function setSchemes(array $schemes = [Scheme::HTTP])
    {
        return array_reduce($schemes, function (Component $acc, string $scheme) {
            return $acc->add('schemes', $scheme);
        }, $this);
    }
}
