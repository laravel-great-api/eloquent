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
     * Undocumented function
     *
     * @param string $key
     * @param string|null $column
     * @return LaravelGreatApi\Eloquent\Store\Relations\Relation
     */
    public static function make(): Relation
    {
        return new static();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create(): void
    {
        $relation = $this->store()->create();

        $this->model->{$this->column()} = $relation->id;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function update(): void
    {
        $this->model->{$this->key()}->store($this->data)->update();
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
