<?php

namespace LaravelGreatApi\Eloquent\Resource\Attributes;

use Closure;
use Illuminate\Database\Eloquent\Model;

/**
 * @method mixed assertValue($value)
 */
class Attribute
{
	/**
	 * Undocumented variable
	 *
	 * @var string
	 */
	private string $name;

	/**
	 * Undocumented variable
	 *
	 * @var mixed
	 */
	private mixed $value = null;

	/**
	 * Undocumented function
	 *
	 * @param string $name
	 */
	public function __construct(string $name, mixed $value = null)
	{
		$this->name = $name;
		$this->setValue($value);
	}

	/**
	 * Undocumented function
	 *
	 * @param string $name
	 * @return mixed
	 */
	public static function make(string $name, mixed $value = null)
	{
		return new static($name, $value);
	}

	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	public function name(): string
	{
		return $this->name;
	}

	/**
	 * Undocumented function
	 *
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue(mixed $value)
	{
		$this->value = $value instanceof Closure ? $value($this) : $value;

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @param Model $resource
	 * @return mixed
	 */
	public function getValue(Model $resource)
	{
		$value = $this->value ?? $resource->{$this->name()};

		if (method_exists($this, 'assertValue')) {
			return $this->assertValue($value);
		}

		return $value;
	}
}
