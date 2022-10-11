<?php

namespace LaravelGreatApi\Eloquent\Store\Relations;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelGreatApi\Eloquent\Store\Store;

/**
 * @method array overrideData
 * @property string $store
 */
abstract class Relation
{
	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	private array $data;

	/**
	 * Undocumented variable
	 *
	 * @var Model
	 */
	protected Model $relation;

	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	protected $storeInstance;

	/**
	 * Undocumented function
	 *
	 * @param Request $request
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;

		$this->storeInstance = $this->createStoreInstance();
	}

	/**
	 * Undocumented function
	 *
	 * @return array
	 */
	protected function data(): array
	{
		if (method_exists($this, 'overrideData')) {
			return $this->overrideData($this->data);
		}

		return $this->data;
	}

	protected function eachData(Closure $callback)
	{
		foreach($this->data() as $data) {
			$callback($data);
		}
	}

	/**
	 * Undocumented function
	 *
	 * @return Store|null
	 */
	protected function createStoreInstance(): ?Store
	{
		if (property_exists($this, 'store')) {
			return app(static::$store);
		}

		return null;
	}

	protected function store($data = null)
	{
		$payload = $data ?? $this->data();

		return $this->storeInstance->create($payload)->getModel();
	}
}
