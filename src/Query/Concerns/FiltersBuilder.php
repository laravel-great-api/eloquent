<?php

namespace LaravelGreatApi\Eloquent\Query\Concerns;

use LaravelGreatApi\Eloquent\Query\Filters\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait FiltersBuilder
{
	/**
	 * Filters Builder
	 *
	 * @param array $data
	 * @param EloquentBuilder $query
	 * @return \LaravelGreatApi\Eloquent\Query\Filters\Builder
	 */
	private function filtersBuilder(array $data, EloquentBuilder $query)
	{
		return new Builder($data, $this->filters(), $query);
	}
}
