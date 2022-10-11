<?php

namespace LaravelGreatApi\Eloquent\Store\Fields;

use LaravelGreatApi\Eloquent\Store\Contracts\Fields\RelationToOne;
use LaravelGreatApi\Eloquent\Store\Fields\Abstraction\Relation;

class BelongsTo extends Relation implements RelationToOne
{
	public static function make($relationName, $fieldName = null)
	{
		return new self($relationName, $fieldName);
	}

	protected function guessColumn()
	{
		return "{$this->relationName}_id";
	}
}
