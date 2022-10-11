<?php

namespace LaravelGreatApi\Eloquent\Store\Fields;

use LaravelGreatApi\Eloquent\Store\Fields\Abstraction\Attribute;

class Arr extends Attribute
{
    /**
     * Create a string attribute.
     *
     * @param string $fieldName
     * @param string|null $column
     * @return Str
     */
    public static function make(string $fieldName, string $column = null): self
    {
        return new self($fieldName, $column);
    }
	
    /**
     * Assert that the attribute JSON value is as expected.
     *
     * @param $value
     * @return void
     */
    protected function assertValue($value): void
    {
        if (!is_array($value)) {
            throw new \UnexpectedValueException(sprintf(
                'Expecting the value of attribute %s to be a array.',
                $this->name()
            ));
        }
    }
}
