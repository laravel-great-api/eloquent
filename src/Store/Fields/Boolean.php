<?php

namespace LaravelGreatApi\Eloquent\Store\Fields;

use UnexpectedValueException;
use LaravelGreatApi\Eloquent\Store\Fields\Abstraction\Attribute;


class Boolean extends Attribute
{
    /**
     * Create a string attribute.
     *
     * @param string $fieldName
     * @param string|null $column
     * @return $this
     */
    public static function make(string $fieldName, string $column = null): self
    {
        return new self($fieldName, $column);
    }

    /**
     * Is the value a numeric value that this field accepts?
     *
     * @param mixed $value
     * @return bool
     */
    private function isBoolean($value): bool
    {
        return is_bool($value) || is_int($value);
    }
	
    /**
     * Assert that the attribute JSON value is as expected.
     *
     * @param $value
     * @return void
     */
    protected function assertValue($value): void
    {
        if (!$this->isBoolean($value)) {
            throw new UnexpectedValueException(sprintf(
                'Expecting the value of attribute %s to be a boolean.',
                $this->name(),
            ));
        }
    }
}
