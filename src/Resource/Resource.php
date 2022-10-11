<?php

namespace LaravelGreatApi\Eloquent\Resource;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LaravelGreatApi\Eloquent\Resource\Attributes\Attribute;
use LaravelGreatApi\Eloquent\Resource\Relationships\DefineRelation;
use LaravelGreatApi\Eloquent\Store\Repositories\Repository;

/**
 * @method array attributes
 * @method array relations
 */
class Resource implements Responsable
{
	/**
	 * Model
	 *
	 * @var \Illuminate\Database\Eloquent\Model
	 */
	protected Model $resource;

	/**
	 * Attributes
	 *
	 * @var array
	 */
	private array $attributes = [];

	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	private array $relations = [];

	/**
	 * Undocumented variable
	 *
	 * @var boolean
	 */
	private bool $created = false;

	/**
	 * Constructor
	 *
	 * @param \Illuminate\Database\Eloquent\Model $data
	 */
	public function __construct(Model|Repository $resource)
	{
		$this->setResource($resource);
	}

	public function __get($key)
	{
		return $this->resource->{$key};
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $name
	 * @param [type] $value
	 * @return $this
	 */
	public function setAttribute(Attribute $attribute)
	{
		$this->attributes[$attribute->name()] = $attribute->getValue($this->resource);

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $relation
	 * @return void
	 */
	public function setRelation($relation)
	{
		$this->relations[$relation->name()] = $relation->get($this->resource);

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @return array
	 */
	public function getRelations()
	{
		return $this->relations;
	}

	private function setResource($resource)
	{
		if ($resource instanceof Model) {
			$this->resource = $resource;
		}

		if ($resource instanceof Repository) {
			$this->resource = $resource->getModel();

			if ($resource->isCreated()) {
				$this->created = true;
			}
		}
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function hasRelationships(): bool
	{
		return method_exists($this, 'relations') && !empty($this->relations(new DefineRelation()));
	}

	/**
	 * Create Resource Builder Instance
	 *
	 * @return \LaravelGreatApi\Eloquent\Resource\ResourceBuilder
	 */
	private function builder($request): ResourceBuilder
	{
		return new ResourceBuilder($this, $request);
	}

	/**
	 * Build resource
	 *
	 * @return mixed
	 */
	public function build(?Request $request = null)
	{
		return $this->builder($request)->build();
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	public function toArray()
	{
		return array_merge(
			$this->getAttributes(),
			$this->getRelations(),
		);
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $request
	 * @return mixed
	 */
	public function toResponse($request)
	{
		// TODO: Сделать нормальный обработчик ответа
		return new Response($this->build($request)->toArray(), $this->created ? 201 : 200);
	}
}
