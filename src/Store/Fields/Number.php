<?php

namespace LaravelGreatApi\Eloquent\Store\Fields;

use UnexpectedValueException;
use LaravelGreatApi\Eloquent\Store\Fields\Abstraction\Attribute;


class Number extends Attribute
{

	/**
	 * Accept Strings
	 *
	 * @var boolean
	 */
    private bool $acceptStrings = false;

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
	 * Accept Strings
	 *
	 * @return $this
	 */
    public function acceptStrings(): self
    {
        $this->acceptStrings = true;

        return $this;
    }

    /**
     * Is the value a numeric value that this field accepts?
     *
     * @param mixed $value
     * @return bool
     */
    private function isNumeric($value): bool
    {
        if (is_null($value) || is_int($value) || is_float($value)) {
            return true;
        }

        if ($this->acceptStrings && is_string($value) && is_numeric($value)) {
            return true;
        }

        return false;
    }
	
    /**
     * Assert that the attribute JSON value is as expected.
     *
     * @param $value
     * @return void
     */
    protected function assertValue($value): void
    {
        if (!$this->isNumeric($value)) {
            $expected = $this->acceptStrings ?
                'an integer, float or numeric string.' :
                'an integer or float.';

            throw new UnexpectedValueException(sprintf(
                'Expecting the value of attribute %s to be ' . $expected,
                $this->name(),
            ));
        }
    }
}
