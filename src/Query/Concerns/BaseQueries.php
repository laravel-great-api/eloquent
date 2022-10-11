<?php

namespace LaravelGreatApi\Eloquent\Query\Concerns;

trait BaseQueries
{
	/**
	 * Get by ids
	 *
	 * @param array $ids
	 * @return mixed
	 */
	public function byIds(array $ids): mixed
	{
		return $this->addQuery(fn($query) => $query->whereIn('id', $ids));
	}

	/**
	 * Undocumented function
	 *
	 * @param string $key
	 * @return $this
	 */
	public function latest($key = 'created_at')
	{
		$this->addQuery(fn($query) => $query->latest($key));

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @param array $data
	 * @return $this
	 */
	public function filter(array $data)
	{
		if (method_exists($this, 'filters')) {
			return $this->addQuery(
				fn($query) => $this->filtersBuilder($data, $query)->build()
			);
		}

		return $this;
	}
}
