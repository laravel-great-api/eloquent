<?php

namespace LaravelGreatApi\Eloquent\Resource\Relationships;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use LaravelGreatApi\Eloquent\Resource\RequestedRelations;

class Relationships
{
	private $relations;

	private $requestedRelations = null;

	public function __construct($relations, ?Request $request)
	{
		$this->relations = $relations;
		$this->requestedRelations = new RequestedRelations($request);
	}

	public function each($callback)
	{
		foreach ($this->relations as $relation) {
			$callback($relation->withRequestedRelations($this->requestedRelations));
		}
	}
}
