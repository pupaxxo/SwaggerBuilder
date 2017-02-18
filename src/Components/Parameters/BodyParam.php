<?php

namespace SwagBag\Components\Parameters;

use SwagBag\Components\Schema;

class BodyParam extends Parameter
{
    public function __construct($name = 'query', $required = false, Schema $schema)
    {
        parent::__construct($name, $required, static::BODY);
        $this->setSchema($schema);
    }

    private function setSchema(Schema $schema): BodyParam
    {
        return $this->set('schema', $schema);
    }
}
