<?php

namespace LaravelGreatApi\Eloquent\Store\Concerns;

use LaravelGreatApi\Eloquent\Store\Store;

trait HasStore
{
	/**
	 * Undocumented variable
	 *
	 * @var Store
	 */
	protected Store $store;

	/**
	 * Undocumented function
	 *
	 * @param Store|string $store
	 * @return $this
	 */
	protected function registerStore(Store|string $store): self
	{
		if ($store instanceof Store) {
			$this->store = $store;
		} else {
			$this->store = app($store);
		}

		return $this;
	}
}
