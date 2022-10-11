<?php

namespace LaravelGreatApi\Eloquent\Query\Filters;

/**
 * @method void apply($value, $builder)
 * @method mixed sanitize($value)
 */
class Filter
{
	/**
	 * Undocumented variable
	 *
	 * @var string
	 */
	protected string $name;

	/**
	 * Undocumented variable
	 *
	 * @var string|null
	 */
	protected ?string $column;

	/**
	 * Undocumented function
	 *
	 * @param string $name
	 */
	public function __construct(string $name, string $column = null)
	{
		$this->name = $name;
		$this->column = $column;
	}

	/**
	 * Undocumented function
	 *
	 * @param string $name
	 * @return \LaravelGreatApi\Eloquent\Query\Filters\Filter
	 */
	public static function make(string $name, ?string $column = null): static
	{
		return new static($name, $column);
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	public function name()
	{
		return $this->name;
	}

	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	protected function column(): string
	{
		if ($this->column === null) {
			return "{$this->name}_id";
		}

		return $this->column;
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function hasSanitize(): bool
	{
		return method_exists($this, 'sanitize');
	}

	/**
	 * Undocumented function
	 *
	 * @param string $value
	 * @param string $separator
	 * @return array
	 */
	protected function split(string $value, string $separator = ',')
	{
		return explode($separator, $value);
	}
}
