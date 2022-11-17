<?php

namespace LaravelGreatApi\Eloquent\Query\Filters;

use Illuminate\Database\Eloquent\Builder;
use LaravelGreatApi\Eloquent\Query\Concerns\SplitValue;
use LaravelGreatApi\Eloquent\Query\Contracts\SanitizableFilter;

class WhereIn extends Filter implements SanitizableFilter
{
	use SplitValue;

    /**
     * Apply the filter after sanitize
	 *
     * @param mixed $value
     * @param  Builder  $builder
	 * @return void
     */
    public function apply($value, Builder $builder): void
    {
        $builder->whereIn($this->column(), $value);
    }
}
