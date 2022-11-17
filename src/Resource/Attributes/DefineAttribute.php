<?php

namespace LaravelGreatApi\Eloquent\Resource\Attributes;

class DefineAttribute
{
	/**
	 * Define ID attribute
	 *
	 * @return array
	 */
	public function id(): array
	{
		return ID::make();
	}

	/**
	 * Define same attribute
	 *
	 * @param string $name
	 * @return \LaravelGreatApi\Eloquent\Resource\Attributes\Attribute
	 */
	public function make(string $name, mixed $value = null): Attribute
	{
		return Attribute::make($name, $value);
	}

	/**
	 * Define timestamps attributes
	 *
	 * @return array
	 */
	public function timestamps(): array
	{
		return Timestamps::make();
	}
}
