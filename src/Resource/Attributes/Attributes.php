<?php

namespace LaravelGreatApi\Eloquent\Resource\Attributes;

use Closure;
use Illuminate\Support\Collection;

class Attributes
{
	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	private array $attributes;

	/**
	 * Undocumented function
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes)
	{
		$this->attributes = Collection::make($attributes)->flatten()->all();
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	public function each(Closure $callback): void
	{
		foreach ($this->attributes as $attribute) {
			$callback($attribute);
		}
	}
}
