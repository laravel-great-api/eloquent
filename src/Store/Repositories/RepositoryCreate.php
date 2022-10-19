<?php

namespace LaravelGreatApi\Eloquent\Store\Repositories;

use Illuminate\Database\Eloquent\Model;
use LaravelGreatApi\Eloquent\Store\Observer;
use LaravelGreatApi\Eloquent\Store\Store;
use LaravelGreatApi\Helpers\Data;

class RepositoryCreate extends Repository
{
	/**
	 * Update Repo Constructor
	 *
	 * @param array $data
	 */
	public function __construct(Model $model, array $data, Store $store)
	{
		$this
			->setModel($model)
			->setData(new Data($data))
			->registerStore($store)
			->registerObserver(new Observer($this));
	}
}
