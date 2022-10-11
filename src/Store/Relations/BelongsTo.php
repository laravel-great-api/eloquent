<?php

namespace LaravelGreatApi\Eloquent\Store\Relations;

class BelongsTo extends Relation
{
	/**
	 * Undocumented function
	 *
	 * @param [type] $field
	 * @param [type] $model
	 * @return void
	 */
	public function create($field, $model)
	{
		$relation = $this->store();

		$model->{$field->getColumn()} = $relation->id;
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $field
	 * @param [type] $model
	 * @return void
	 */
	public function update($field, $model)
	{
		$this->storeInstance->update($this->data(), $model);
	}
}
