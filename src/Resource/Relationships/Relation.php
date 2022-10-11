<?php

namespace LaravelGreatApi\Eloquent\Resource\Relationships;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class Relation
{
	private $name;

	private $resource = null;

	private $requestedRelations;

	public function __construct($name, $resource)
	{
		$this->name = $name;
		$this->resource = $resource;
	}

	public static function make($name, $resource = null)
	{
		return new self($name, $resource);
	}

	public function name()
	{
		return $this->name;
	}

	public function withRequestedRelations($requestedRelations)
	{
		$this->requestedRelations = $requestedRelations;

		return $this;
	}

	private function resource($relationModel)
	{
		return new ($this->resource)($relationModel);
	}

	private function buildResource($model)
	{
		return $this->resource($model)->build()->toArray();
	}

	public function get($model)
	{
		$relation = $model->{Str::camel($this->name())};

		if ($this->resource) {
			if ($relation instanceof Collection) {
				return $relation->map(fn($model) => $this->buildResource($model));
			}

			return $this->buildResource($relation);
		}

		return $relation;
	}
}
