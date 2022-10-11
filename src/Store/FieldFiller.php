<?php

namespace LaravelGreatApi\Eloquent\Store;

use Illuminate\Database\Eloquent\Model;
use LaravelGreatApi\Eloquent\Store\Fields\Abstraction\Attribute;
use LaravelGreatApi\Helpers\Data;

class FieldFiller
{
	/**
	 * Undocumented variable
	 *
	 * @var Attribute
	 */
	private Attribute $field;

	/**
	 * Undocumented variable
	 *
	 * @var Model
	 */
	private Model $model;

	/**
	 * Undocumented variable
	 *
	 * @var Data
	 */
	private Data $data;

	/**
	 * Undocumented function
	 *
	 * @param Attribute $field
	 * @param Model $model
	 */
	public function __construct(Attribute $field, Data $data, Model $model)
	{
		$this->field = $field;
		$this->data = $data;
		$this->model = $model;
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	private function canBeFilled(): bool
	{
		return $this->field->isReadOnly() === false;
	}

	/**
	 * Get Field Value
	 *
	 * @return mixed
	 */
	private function value()
	{
		return $this->data->get($this->field->name(), $this->field->getDefaultValue());
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function fill()
	{
		$value = $this->value();

		if ($value !== null && $this->canBeFilled()) {
			$this->field->fill($this->model, $value);
		}
	}
}
