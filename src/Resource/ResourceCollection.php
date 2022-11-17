<?php

namespace LaravelGreatApi\Eloquent\Resource;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

/**
 * @method mixed resource($model)
 */
class ResourceCollection implements Responsable
{
	/**
	 * Undocumented variable
	 *
	 * @var \LaravelGreatApi\Eloquent\Resource\CollectionBuilder
	 */
	private CollectionBuilder $builder;

	/**
	 * Undocumented variable
	 *
	 * @var array|null
	 */
	private ?array $meta = null;

	/**
	 * Undocumented function
	 *
	 * @param mixed $collection
	 */
	public function __construct($collection)
	{
		$this->builder = new CollectionBuilder($this, $collection);

		if ($collection instanceof LengthAwarePaginator) {
			$this->meta = $this->meta($collection->toArray());
		}
	}

    /**
     * Gather the meta data for the response.
     *
     * @param  array  $paginated
     * @return array
     */
    protected function meta($paginated)
    {
        return Arr::except($paginated, [
            'data',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]);
    }

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	public function toResponse($request)
	{
		return array_filter([
			'data' => $this->builder->build($request),
			'meta' => $this->meta,
		]);
	}
}
