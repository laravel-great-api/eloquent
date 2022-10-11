<?php

namespace LaravelGreatApi\Eloquent\Store\Concerns;

use LaravelGreatApi\Eloquent\Store\Repositories\RepositoryCreate;

trait HasCreate
{
	/**
	 * Undocumented function
	 *
	 * @param array $data
	 * @return RepositoryCreate
	 */
	public function create(array $data): RepositoryCreate
	{
		return new RepositoryCreate($this->relation?->getRelated() ?? new static::$model, $data, $this);
	}
}
