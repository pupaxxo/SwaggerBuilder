<?php

namespace SwagBag\Traits;

use SwagBag\Components\Component;
use SwagBag\Constants\Mime;

trait Mimes
{
    /**
     * @param string[] $mimes
     * @return static
     */
    public function setConsumedMimes(array $mimes = [Mime::APP_JSON])
    {
        return array_reduce($mimes, function (Component $acc, string $mime) {
            return $acc->add('consumes', $mime);
        }, $this);
    }

    /**
     * @param string[] $mimes
     * @return static
     */
    public function setProducedMimes(array $mimes = [Mime::APP_JSON])
    {
        return array_reduce($mimes, function (Component $acc, string $mime) {
            return $acc->add('produces', $mime);
        }, $this);
    }
}
