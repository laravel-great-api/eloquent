<?php

namespace LaravelGreatApi\Eloquent\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use LaravelGreatApi\Eloquent\Store\Repositories\RepositoryCreate;
use LaravelGreatApi\Eloquent\Store\Repositories\RepositoryUpdate;

/**
 * Undocumented class
 *
 * @property Model $model
 * @method static \LaravelGreatApi\Eloquent\Store\Repositories\RepositoryCreate create($data)
 * @method \LaravelGreatApi\Eloquent\Store\Repositories\RepositoryCreate create($data)
 * @method static \LaravelGreatApi\Eloquent\Store\Repositories\RepositoryUpdate update($data, $model)
 * @method void beforeCreate($model, $data)
 * @method void beforeUpdate($model, $data)
 * @method void afterCreate($model, $data)
 * @method void afterUpdate($model, $data)
 */
abstract class Store
{
	/**
	 * Undocumented function
	 *
	 * @param [type] $method
	 * @param [type] $parameters
	 * @return mixed
	 */
    public static function __callStatic($method, $parameters)
    {
		return (new static)->$method(...$parameters);
    }

	/**
	 * Undocumented function
	 *
	 * @param [type] $method
	 * @param [type] $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		if (in_array($method, ['create', 'update'])) {
			return $this->{$method . 'Repository'}(...array_values($parameters));
		}
	}

	/**
	 * Undocumented variable
	 *
	 * @var Relation|null
	 */
	private ?Relation $relation = null;

	/**
	 * Define Fields
	 *
	 * @return array
	 */
	abstract public function fields($field, $data): array;

	/**
	 * Undocumented function
	 *
	 * @param array $data
	 * @return RepositoryCreate
	 */
	public function createRepository(array $data): RepositoryCreate
	{
		return new RepositoryCreate($this->relation?->getRelated() ?? new static::$model, $data, $this);
	}

	/**
	 * Undocumented function
	 *
	 * @param array $data
	 * @return RepositoryUpdate
	 */
	public function updateRepository(array $data, Model $model): RepositoryUpdate
	{
		return new RepositoryUpdate($model, $data, $this);
	}

	public static function updateMany(array $ids, array $data)
	{
		$query = static::$model::whereIn('id', $ids);

		$query->each(fn($model) => self::newInstance()->update($data, $model)->getModel());

		return $query->get();
	}

	/**
	 * Registration Relationship
	 *
	 * @param Relation $relation
	 * @return $this
	 */
	public function relation(Relation $relation)
	{
		$this->relation = $relation;

		return $this;
	}

	public function isRelation(): bool
	{
		return $this->relation !== null;
	}

	/**
	 * Get Relationship
	 *
	 * @return Relation
	 */
	public function getRelation(): Relation
	{
		return $this->relation;
	}

	/**
	 * Hook Manager
	 *
	 * @param Model $model
	 * @return \LaravelGreatApi\Eloquent\Store\HookManager
	 */
	public function hookManager(Model $model): HookManager
	{
		return new HookManager($this, $model);
	}

	/**
	 * Undocumented function
	 *
	 * @return \LaravelGreatApi\Eloquent\Store\Store
	 */
	public static function newInstance(): self
	{
		return App::make(static::class);
	}

    /**
     * Undocumented function
     *
     * @param string $store
     * @return Store
     */
    public static function of(string $store): Store
    {
        return $store::newInstance();
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function hasRelations(): bool
    {
        return method_exists($this, 'relations');
    }
}
