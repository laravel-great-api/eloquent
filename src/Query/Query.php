<?php

namespace LaravelGreatApi\Eloquent\Query;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelGreatApi\Eloquent\Query\Concerns\BaseQueries;
use LaravelGreatApi\Eloquent\Query\Concerns\FiltersBuilder;
use LaravelGreatApi\Eloquent\Query\Concerns\Paginated;

/**
 * @property string $model
 * @method array filters
 * @method mixed collection
 * @method mixed resource
 */
class Query
{
	use Paginated, FiltersBuilder, BaseQueries;

    /**
     * Undocumented variable
     *
     * @var Request
     */
    private Request $request;

	/**
	 * Create Resource Builder Instance
	 *
	 * @return \LaravelGreatApi\Eloquent\Query\Data
	 */
	private function data(): Data
	{
		return new Data($this);
	}

    /**
     * Get response
     *
     * @return mixed
     */
    public function get()
    {
		return $this->data()->get();
    }

	/**
	 * Undocumented function
	 *
	 * @param callable $callback
	 * @return mixed
	 */
	public function each(callable $callback)
	{
		return $this->get()->each($callback);
	}

	/**
	 * Undocumented function
	 *
	 * @param callable $callback
	 * @return mixed
	 */
	public function map(callable $callback)
	{
		return $this->get()->map($callback);
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	public function exists()
	{
		return $this->builder()->exists();
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	public function count()
	{
		return $this->builder()->count();
	}

	/**
	 * Add Query
	 *
	 * @param callable $callback
	 * @return mixed
	 */
	public function addQuery(callable $callback)
	{
		$this->query = $callback($this->builder());

		return $this;
	}

	/**
	 * Get query
	 *
	 * @return mixed
	 */
	public function builder()
	{
		return $this->query ?? $this->getModel()->newQuery();
	}

	/**
	 * Get Model Instance
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function getModel(): Model
	{
		return new static::$model;
	}

	/**
	 * Set Query
	 *
	 * @param [type] $query
	 * @return $this
	 */
	public function setQuery($query)
	{
		$this->query = $query;

		return $this;
	}

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return Query
     */
    public function withRequest(Request $request): Query
    {
        $this->request = $request;

        return $this;
    }
}
