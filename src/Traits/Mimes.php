<?php

namespace SwagBag\Traits;

use SwagBag\Mime;

trait Mimes
{
    use JsonStruct;

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
