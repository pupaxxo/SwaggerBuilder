<?php

namespace SwagBag\Traits;

use SwagBag\Mime;

trait Mimes
{
    use JsonStruct;

    public function addConsumedMime(string $mime = Mime::JSON)
    {
        return $this->append('consumes', $mime);
    }

    public function addProducedMime(string $mime = Mime::JSON)
    {
        return $this->append('produces', $mime);
    }
}
