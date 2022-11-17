<?php

namespace LaravelGreatApi\Eloquent\Store;

use Illuminate\Database\Eloquent\Model;
use LaravelGreatApi\Helpers\Data;

class HookManager
{
	/**
	 * Model
	 *
	 * @var Model
	 */
	private Store $store;

	/**
	 * Model
	 *
	 * @var Model
	 */
	private Model $model;

	/**
	 * Payload Data
	 *
	 * @var Data
	 */
	private Data $data;

	/**
	 * Hook Manager Constructor
	 *
	 * @param Model $model
	 */
	public function __construct(Store $store, Model $model)
	{
		$this->store = $store;
		$this->model = $model;
	}

	/**
	 * Set Payload Data
	 *
	 * @param Data $data
	 * @return $this
	 */
	public function withData(Data $data): HookManager
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Store Hooks Dispatcher
	 *
	 * @param string $method
	 * @return void
	 */
	public function dispatch(string $method): void
	{
		if (method_exists($this->store, $method)) {
			$this->store->{$method}($this->model, $this->data);
		}
	}
}
