<?php

namespace LaravelGreatApi\Eloquent\Store\Fields;

use LaravelGreatApi\Eloquent\Store\Contracts\Fields\RelationToMany;
use LaravelGreatApi\Eloquent\Store\Fields\Abstraction\Relation;

class HasMany extends Relation implements RelationToMany
{
	public static function make($relationName, $column = null)
	{
		return new self($relationName, $column);
	}
}
