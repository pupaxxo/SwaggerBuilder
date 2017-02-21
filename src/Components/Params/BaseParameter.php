<?php

namespace SwaggerBuilder\Components\Params;

use SwaggerBuilder\Components\Component;
use SwaggerBuilder\Constants\Type;
use SwaggerBuilder\Traits\Description;
use SwaggerBuilder\Traits\Format;

abstract class BaseParameter extends Component
{
    use Description, Format;

    const QUERY = 'query';
    const HEADER = 'header';
    const FORM = 'formData';
    const BODY = 'body';
    const PATH = 'path';

    public function __construct(
        string $name = 'filter',
        string $in = self::QUERY,
        string $type = Type::STRING,
        bool $required = false
    ) {
        $this
            ->setName($name)
            ->setIn($in)
            ->setType($type)
            ->setRequired($required);
    }

    private function setRequired(bool $required): BaseParameter
    {
        return $this->set('required', $required);
    }

    private function setType(string $type): BaseParameter
    {
        return $this->set('type', $type);
    }

    private function setIn(string $in): BaseParameter
    {
        return $this->set('in', $in);
    }

    private function setName(string $name): BaseParameter
    {
        return $this->set('name', $name);
    }
}
