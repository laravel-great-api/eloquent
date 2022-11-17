<?php

namespace LaravelGreatApi\Eloquent\Resource;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CollectionBuilder
{
	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private ResourceCollection $resourceCollection;

	/**
	 * Collection
	 *
	 * @var Collection
	 */
	private Collection $collection;

	/**
	 * Undocumented function
	 *
	 * @param [type] $collection
	 */
	public function __construct($resourceCollection, $data)
	{
		$this->resourceCollection = $resourceCollection;
		$this->collection = $this->collect($data);
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $collection
	 * @return \Illuminate\Support\Collection
	 */
	private function collect($data)
	{
		return $data instanceof LengthAwarePaginator ? $data->getCollection() : $data;
	}

	/**
	 * Build resource collection
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function build(?Request $request): Collection
	{
		return $this->collection->map(
			fn($item) => $this->resourceCollection->resource($item)->build($request)->toArray()
		);
	}
}
