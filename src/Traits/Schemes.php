<?php

namespace SwaggerBuilder\Traits;

use SwaggerBuilder\Components\Component;
use SwaggerBuilder\Constants\Scheme;

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
