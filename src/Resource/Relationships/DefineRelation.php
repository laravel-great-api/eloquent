<?php

namespace LaravelGreatApi\Eloquent\Resource\Relationships;

class DefineRelation
{
	/**
	 * Make a relation definition
	 *
	 * @param string $name
	 * @param string|null $resource
	 * @return \LaravelGreatApi\Eloquent\Resource\Relationships\Relation
	 */
	public function make(string $name, ?string $resource = null)
	{
		return Relation::make($name, $resource);
	}
}
