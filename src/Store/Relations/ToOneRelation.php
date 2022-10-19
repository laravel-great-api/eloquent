<?php

namespace LaravelGreatApi\Eloquent\Store\Relations;

use Illuminate\Database\Eloquent\Model;
use LaravelGreatApi\Eloquent\Store\Store;
use LaravelGreatApi\Helpers\Data;

/**
 * @property string $store
 */
class ToOneRelation extends Relation
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected string $key;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected string $column;

    /**
     * Undocumented variable
     *
     * @var Data
     */
    protected Data $data;

    /**
     * Comstructor
     *
     * @param string $key
     * @param string|null $column
     */
    public function __construct(string $key, ?string $column = null)
    {
        $this->key = $key;
        $this->column = $column ?? "{$key}_id";
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @param string|null $column
     * @return LaravelGreatApi\Eloquent\Store\Relations\Relation
     */
    public static function make(string $key, ?string $column = null): Relation
    {
        return new static($key, $column);
    }

    /**
     * Undocumented function
     *
     * @param Model $model
     * @param array $data
     * @return void
     */
    public function create(Model $model, array $data): void
    {
        $this->data = new Data($data);

        $relation = Store::of($this->getStore())->create($data)->getModel();

        $model->{$this->column()} = $relation->id;
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return void
     */
    public function update(Model $model, array $data): void
    {
        Store::of($this->getStore())->update($data, $model->{$this->key});
    }

    /**
     * Undocumented function
     *
     * @param Model $model
     * @return void
     */
    public function delete(Model $model): void
    {
        //
    }
}
