<?php

namespace LaravelGreatApi\Eloquent\Store\Fields;

use LaravelGreatApi\Eloquent\Store\Fields\Abstraction\Attribute;
use LaravelGreatApi\Helpers\Generator;

class UniqueStr extends Attribute
{
	/**
	 * Str Letgth
	 *
	 * @var integer
	 */
	private static int $length;

    /**
     * Create a string attribute.
     *
     * @param string $fieldName
     * @param string|null $column
     * @return UniqueStr
     */
    public static function make(string $fieldName, int $length = 5, string $column = null): self
    {
		self::$length = $length;

        return new self($fieldName, $column);
    }

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	protected function defineDefaultValue()
	{
		return Generator::id(static::$length);
	}
	
    /**
     * Assert that the attribute JSON value is as expected.
     *
     * @param $value
     * @return void
     */
    protected function assertValue($value): void
    {
        if (!is_null($value) && !is_string($value)) {
            throw new \UnexpectedValueException(sprintf(
                'Expecting the value of attribute %s to be a string.',
                $this->name()
            ));
        }
    }
}
