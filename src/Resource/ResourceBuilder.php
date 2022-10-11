<?php

namespace LaravelGreatApi\Eloquent\Resource;

use Illuminate\Http\Request;
use LaravelGreatApi\Eloquent\Resource\Attributes\Attribute;
use LaravelGreatApi\Eloquent\Resource\Attributes\Attributes;
use LaravelGreatApi\Eloquent\Resource\Attributes\DefineAttribute;
use LaravelGreatApi\Eloquent\Resource\Relationships\DefineRelation;
use LaravelGreatApi\Eloquent\Resource\Relationships\Relationships;

class ResourceBuilder
{
	/**
	 * Resource instance
	 *
	 * @var \LaravelGreatApi\Eloquent\Resource\Resource
	 */
	private Resource $resource;

	/**
	 * Undocumented variable
	 *
	 * @var \LaravelGreatApi\Eloquent\Resource\Attributes\Attributes
	 */
	private Attributes $attributes;

	/**
	 * Undocumented variable
	 *
	 * @var \LaravelGreatApi\Eloquent\Resource\Attributes\Attributes
	 */
	private Relationships $relationships;

	/**
	 * Constructor
	 *
	 * @param \LaravelGreatApi\Eloquent\Resource\Resource $resource
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param \Illuminate\Http\Request $request
	 */
	public function __construct(Resource $resource, ?Request $request)
	{
		$this->resource = $resource;
		$this->attributes = new Attributes($this->resource->attributes(new DefineAttribute()));

		if ($this->resource->hasRelationships()) {
			$this->relationships = new Relationships($this->resource->relations(new DefineRelation()), $request);
		}
	}

	/**
	 * Undocumented function
	 *
	 * @return \LaravelGreatApi\Eloquent\Resource\Resource
	 */
	public function build(): Resource
	{
		$this->attributes->each(
			fn(Attribute $attribute) => $this->resource->setAttribute($attribute)
		);

		if ($this->resource->hasRelationships()) {
			$this->relationships->each(
				fn($relation) => $this->resource->setRelation($relation)
			);
		}

		return $this->resource;
	}
}
