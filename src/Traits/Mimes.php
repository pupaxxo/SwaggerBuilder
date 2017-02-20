<?php

namespace SwagBag\Traits;

use SwagBag\Constants\Mime;

trait Mimes
{
    /**
     * @param string $mime
     * @return static
     */
    public function addConsumedMime(string $mime = Mime::JSON)
    {
        return $this->add('consumes', $mime);
    }

    /**
     * @param string $mime
     * @return static
     */
    public function addProducedMime(string $mime = Mime::JSON)
    {
        return $this->add('produces', $mime);
    }
}
