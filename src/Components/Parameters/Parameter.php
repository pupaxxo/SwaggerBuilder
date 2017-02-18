<?php

namespace SwagBag\Components\Parameters;

use SwagBag\Components\Component;
use SwagBag\Traits\Patterned;

abstract class Parameter extends Component
{
    use Patterned;

    const PATH = 'path';
    const QUERY = 'query';
    const HEADER = 'header';
    const BODY = 'body';
    const FORM = 'formData';

    private $name;

    public function __construct(string $name = 'query', bool $required = false, string $in = self::QUERY)
    {
        $this->name = $name;
        $this
            ->setRequired($required)
            ->setIn($in);
    }

    private function setIn(string $in): Parameter
    {
        return $this->set('in', $in);
    }

    private function setRequired(bool $required): Parameter
    {
        return $this->set('required', $required);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(string $description = 'Data passed by the client.'): Parameter
    {
        return $this->set('description', $description);
    }
}
