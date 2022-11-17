<?php

namespace LaravelGreatApi\Eloquent\Resource;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use LaravelGreatApi\Eloquent\Resource\Relationships\Relation;

class RequestedRelations
{
	private $request;

	private $relations;

	public function __construct($request)
	{
		$this->request = $request;
		$this->relations = $this->relations($request ? $request->get('include') : null);
	}

	private function relations($relations)
	{
		if ($relations) {
			return Collection::make(explode(',', $relations))->map(
				fn($item) => [Str::of($item)->before('.')->camel()->toString() => explode('.', $item)]
			)->collapse();
		}

		return null;
	}

	public function getRelations()
	{
		return $this->relations;
	}
}
