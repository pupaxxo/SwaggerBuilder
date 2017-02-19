<?php

namespace SwagBag\Components\Parameters;

use InvalidArgumentException;
use SwagBag\Type;

abstract class OtherParam extends Parameter
{
    public function __construct(
        string $name = 'query',
        bool $required = false,
        string $type = Type::STRING
    ) {
        parent::__construct($name, $required);
        $this->setType($type);
    }

    private function setType(string $type = Type::STRING): OtherParam
    {
        return $this->set('type', $type);
    }

    public function setCollectionFormat(string $format = CollectionFormat::CSV): OtherParam
    {
        if ($format == CollectionFormat::MULTI && !in_array($this->structure['in'], [QueryParam::IN, FormParam::IN])) {
            throw new InvalidArgumentException(sprintf(
                "Cannot set parameter %s format to %s because it is in the %s, not the %s or %s",
                $this->structure['name'],
                $format,
                $this->structure['in'],
                QueryParam::IN,
                FormParam::IN
            ));
        }
        return $this->set('collectionFormat', $format);
    }

    /**
     * @param mixed $default
     * @return OtherParam
     */
    public function setDefault($default): OtherParam
    {
        return $this->set('default', $default);
    }

    /**
     * @param int|float $maximum
     * @return OtherParam
     */
    public function setMaximum($maximum = 100): OtherParam
    {
        return $this->set('maximum', $maximum);
    }

    public function setExclusiveMaximum(bool $exclusive = false): OtherParam
    {
        return $this->set('exclusiveMaximum', $exclusive);
    }

    /**
     * @param int|float $minimum
     * @return OtherParam
     */
    public function setMinimum($minimum = 0): OtherParam
    {
        return $this->set('minimum', $minimum);
    }

    public function setExclusiveMinimum(bool $exclusive = false): OtherParam
    {
        return $this->set('exclusiveMinimum', $exclusive);
    }

    public function setMaxLength(int $maxLength = 144): OtherParam
    {
        return $this->set('maxLength', $maxLength);
    }

    public function setMinLength(int $minLength = 0): OtherParam
    {
        return $this->set('minLength', $minLength);
    }

    public function setPattern(string $regex = '/[a-zA-Z0-9]+/'): OtherParam
    {
        return $this->set('pattern', $regex);
    }

    /**
     * @param int|float $number
     * @return OtherParam
     */
    public function setMultipleOf($number): OtherParam
    {
        return $this->set('multipleOf', $number);
    }
}
