<?php

namespace SwagBag\Components\Params;

use SwagBag\Components\Schema;

class BodyParameter extends BaseParameter
{
    public function __construct($name = 'id', bool $required = false, Schema $schema)
    {
        parent::__construct($name, static::BODY, static::BODY, $required);
        unset($this->structure['type']);
        $this->setSchema($schema);
    }

    private function setSchema(Schema $schema): BodyParameter
    {
        return $this->set('schema', $schema);
    }
}
