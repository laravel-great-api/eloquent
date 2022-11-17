<?php

namespace LaravelGreatApi\Eloquent\Store;

use Illuminate\Database\Eloquent\Model;
use LaravelGreatApi\Eloquent\Store\Relations\Relation;
use LaravelGreatApi\Eloquent\Store\Repositories\Repository;
use LaravelGreatApi\Helpers\Data;

class RelationManager
{
	/**
	 * Undocumented variable
	 *
	 * @var Relation
	 */
	private Relation $relation;

	/**
	 * Undocumented variable
	 *
	 * @var Data
	 */
	private Data $data;

	/**
	 * Undocumented variable
	 *
	 * @var Model
	 */
	private Model $model;

	/**
	 * Undocumented variable
	 *
	 * @var Repository
	 */
	private Repository $repository;

	/**
	 * Undocumented function
	 *
	 * @param \LaravelGreatApi\Eloquent\Store\Relations\Relation $relation
	 * @param \LaravelGreatApi\Helpers\Data $data
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param \LaravelGreatApi\Eloquent\Store\Repositories\Repository $repository
	 */
	public function __construct(Relation $relation, Data $data, Model $model, Repository $repository)
	{
		$this->relation = $relation;
		$this->data = $data;
		$this->model = $model;
		$this->repository = $repository;
	}

    public function create()
    {
        $this
            ->relation
            ->setModel($this->model)
            ->setData($this->data)
            ->create();
    }

    public function update()
    {
        $this
            ->relation
            ->setModel($this->model)
            ->setData($this->data)
            ->update();
    }
}
