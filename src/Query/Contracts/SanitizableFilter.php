<?php

namespace LaravelGreatApi\Eloquent\Query\Contracts;

interface SanitizableFilter extends Filter
{
	/**
	 * Undocumented function
	 *
	 * @param string $value
	 * @return mixed
	 */
	public function sanitize(string $value);
}
