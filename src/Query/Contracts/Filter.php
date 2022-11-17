<?php

namespace LaravelGreatApi\Eloquent\Query\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * Apply the filter after sanitize
	 *
     * @param mixed $value
     * @param Builder $builder
     */
    public function apply(mixed $value, Builder $builder): void;
}
