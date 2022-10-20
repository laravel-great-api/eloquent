<?php

namespace LaravelGreatApi\Eloquent\Store;

use Closure;
use Illuminate\Database\Eloquent\Model;
use LaravelGreatApi\Eloquent\Store\Repositories\Repository;

class Observer
{
	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	private static array $events = [
		'creating' => 'beforeCreate',
		'created' => 'afterCreate',
		'updating' => 'beforeUpdate',
		'updated' => 'afterUpdate',
		'deleting' => 'beforeDelete',
		'deleted' => 'afterDelete',
	];

	/**
	 * Undocumented variable
	 *
	 * @var Repository
	 */
	private Repository $repository;

	/**
	 * Undocumented function
	 *
	 * @param Repository $repository
	 */
	public function __construct(Repository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function boot()
	{
		foreach(self::$events as $listener => $hook) {
			$this->{$listener}(function(Store $store, Model $model) use($hook) {
				$store
					->hookManager($model)
					->withData($this->getRepositoryData())
					->dispatch($hook);
			});
		}
	}

	/**
	 * Undocumented function
	 *
	 * @return Store
	 */
	public function getStore(): Store
	{
		return $this->repository->getStore();
	}

	/**
	 * Undocumented function
	 *
	 * @return Model
	 */
	public function getModel(): Model
	{
		return $this->repository->getModel();
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	private function getRepositoryData()
	{
		return $this->repository->getData();
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	private function isCreating(): bool
	{
		return $this->repository->isCreate() && $this->repository->isSaving();
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	private function isCreated(): bool
	{
		return $this->repository->isCreate() && $this->repository->isSaved();
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	private function isUpdating(): bool
	{
		return $this->repository->isUpdate() && $this->repository->isSaving();
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	private function isUpdated(): bool
	{
		return $this->repository->isUpdate() && $this->repository->isSaved();
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	protected function creating(Closure $callback)
	{
		if ($this->isCreating()) {
			$callback($this->getStore(), $this->getModel());
		}
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	protected function created(Closure $callback)
	{
		if ($this->isCreated()) {
			$callback($this->getStore(), $this->getModel());
		}
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	protected function updating(Closure $callback)
	{
		if ($this->isUpdating()) {
			$callback($this->getStore(), $this->getModel());
		}
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	protected function deleting(Closure $callback)
	{
		if ($this->repository->isDelete()) {
			$callback($this->getStore(), $this->getModel());
		}
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	protected function deleted(Closure $callback)
	{
		if ($this->repository->isDelete()) {
			$callback($this->getStore(), $this->getModel());
		}
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	protected function beforeSave()
	{
		$this->boot();
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	protected function afterSave()
	{
		$this->boot();
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	protected function beforeDelete()
	{
		$this->boot();
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	protected function afterDelete()
	{
		$this->boot();
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $method
	 * @return void
	 */
	public function dispatch($method)
	{
		if (method_exists($this, $method)) {
			$this->{$method}();
		}
	}
}
