<?php

namespace LaravelGreatApi\Eloquent\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use LaravelGreatApi\Eloquent\Store\Repositories\RepositoryCreate;
use LaravelGreatApi\Eloquent\Store\Repositories\RepositoryUpdate;

/**
 * @method void beforeCreate($model, $data)
 * @method void beforeUpdate($model, $data)
 * @method void afterCreate($model, $data)
 * @method void afterUpdate($model, $data)
 */
class Store
{
	/**
	 * Undocumented variable
	 *
	 * @var \Illuminate\Database\Eloquent\Relations\Relation|null
	 */
	private ?Relation $relation = null;

    /**
     * Undocumented variable
     *
     * @var \LaravelGreatApi\Eloquent\Store\Repositories\RepositoryCreate
     */
    private RepositoryCreate $create;

    /**
     * Undocumented variable
     *
     * @var \LaravelGreatApi\Eloquent\Store\Repositories\RepositoryUpdate
     */
    private RepositoryUpdate $update;

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Relations\Relation|null $relation
     */
    public function __construct(Model $model, array $data, ?Relation $relation = null)
    {
        $this->ceate = new RepositoryCreate($relation ?? $model, $data, $this);
        $this->update = new RepositoryUpdate($model, $data, $this);
    }

	/**
	 * Undocumented function
	 *
	 * @return Model
	 */
	public function create(): Model
	{
		return $this->ceate->store();
	}

	/**
	 * Undocumented function
	 *
	 * @return Model
	 */
	public function update(): Model
	{
		return $this->update->store();
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
