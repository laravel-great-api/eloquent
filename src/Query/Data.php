<?php

namespace LaravelGreatApi\Eloquent\Query;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Data
{
	/**
	 * Query instance
	 *
	 * @var LaravelGreatApi\Eloquent\Query\Query
	 */
	private Query $query;

	/**
	 * Extracted data
	 *
	 * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
	 */
	private Collection|LengthAwarePaginator $data;

	/**
	 * Constructor
	 *
	 * @param Query $query
	 */
	public function __construct(Query $query)
	{
		$this->query = $query;
		$this->data = $this->extract();
	}

	/**
	 * Get query builder instance
	 *
	 * @return mixed
	 */
	private function query()
	{
		return $this->query->builder();
	}

	/**
	 * Retrieving data from the database
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
	 */
	private function extract(): Collection|LengthAwarePaginator
	{
		if ($this->query->isPaginated()) {
			return $this->query()->simplePaginate($this->query->getlimit());
		}

		return $this->query()->get();
	}

	/**
	 * Get extracted data
	 *
	 * @return void
	 */
	public function get()
	{
		return $this->data;
	}
}
