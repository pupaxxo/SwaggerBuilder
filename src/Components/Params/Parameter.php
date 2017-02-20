<?php

namespace SwagBag\Components\Params;

use SwagBag\Components\Component;
use SwagBag\ParamType;
use SwagBag\Traits\Items;

class Parameter extends Component
{
    use Items;

    const QUERY = 'query';
    const HEADER = 'header';
    const FORM = 'formData';

    public function __construct(
        string $name = 'filter',
        string $in = self::QUERY,
        string $type = ParamType::STRING,
        bool $required = false
    ) {
        $this
            ->setName($name)
            ->setIn($in)
            ->setType($type)
            ->setRequired($required);
    }

    private function setRequired(bool $required): Parameter
    {
        return $this->set('required', $required);
    }

    private function setType(string $type): Parameter
    {
        return $this->set('type', $type);
    }

    private function setIn(string $in): Parameter
    {
        return $this->set('in', $in);
    }

    private function setName(string $name): Parameter
    {
        return $this->set('name', $name);
    }

    public function setDescription(string $description = 'Filters include [name, email]'): Parameter
    {
        return $this->set('description', $description);
    }

    public function setMin($minimum): Parameter
    {
        return $this
            ->set('minimum', $minimum)
            ->set('exclusiveMinimum', false);
    }

    public function setMax($maximum): Parameter
    {
        return $this
            ->set('maximum', $maximum)
            ->set('exclusiveMinimum', false);
    }

    public function setMinLength(int $minLength = 0): Parameter
    {
        return $this->set('minLength', $minLength);
    }

    public function setMaxLength(int $maxLength = 144): Parameter
    {
        return $this->set('maxLength', $maxLength);
    }
}
