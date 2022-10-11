<?php

namespace LaravelGreatApi\Eloquent\Store\Relations;

class HasMany extends Relation
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
		$this->eachData(function($data) use($field, $model) {
			$this->store(array_merge($data, [$field->getColumn() => $model->id]));
		});
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
		// 
	}
}
