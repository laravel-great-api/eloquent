<?php

namespace LaravelGreatApi\Eloquent\Traits;

trait RelationForwardCall
{
	private $relation;

	public function __construct($relation)
	{
		$this->relation = $relation;
	}

	public function __call(string $name, mixed $arguments)
	{
		return $this->relation->{$name}(...$arguments);
	}
}
