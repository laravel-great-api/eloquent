<?php

namespace LaravelGreatApi\Eloquent\Store;

use Illuminate\Database\Eloquent\Model;
use LaravelGreatApi\Eloquent\Store\Fields\Abstraction\Relation;
use LaravelGreatApi\Eloquent\Store\Repositories\Repository;
use LaravelGreatApi\Eloquent\Store\Repositories\RepositoryCreate;
use LaravelGreatApi\Eloquent\Store\Repositories\RepositoryUpdate;
use LaravelGreatApi\Helpers\Data;

class RelationManager
{
	/**
	 * Undocumented variable
	 *
	 * @var Relation
	 */
	private Relation $field;

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
	 * @param Relation $field
	 * @param Data $data
	 * @param Model $model
	 * @param Repository $repository
	 */
	public function __construct(Relation $field, Data $data, Model $model, Repository $repository)
	{
		$this->field = $field;

		$this->data = $data;

		$this->model = $model;

		$this->repository = $repository;
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	private function getRelation()
	{
		return $this->field->getRelationName();
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	private function relationMethod()
	{
		return "{$this->getRelation()}Relation";
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	private function getRelationData()
	{
		return $this->data->get($this->getRelation());
	}

	/**
	 * Undocumented function
	 *
	 * @return Store
	 */
	private function getStore()
	{
		return $this->repository->getStore();
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	private function getRelationClass()
	{
		return $this->getStore()->{$this->relationMethod()}($this->getRelationData()); 
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	public function create()
	{
		$this->getRelationClass()->create($this->field, $this->model);
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	public function update()
	{
		$this->getRelationClass()->update($this->field, $this->model->{$this->getRelation()});
	}
}
