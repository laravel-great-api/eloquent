<?php

namespace LaravelGreatApi\Eloquent\Store\Relations;

class BelongsToMany extends Relation
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
		$model->{$field->relation()}()->sync($this->data());
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
		$model->{$field->relation()}()->sync($this->data());
	}
}
