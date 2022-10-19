<?php

namespace LaravelGreatApi\Eloquent\Store\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LaravelGreatApi\Eloquent\Store\Store;

class MorphTo extends ToOneRelation
{
    /**
     * Undocumented function
     *
     * @param Model $model
     * @param array $data
     * @return void
     */
    public function create(Model $model, array $data): void
    {
        $relation = Store::of($this->getStore())->create($data)->getModel();

        $model->{$this->column()} = $relation->id;
        $model->{Str::replace('_id', '_type', $this->column())} = $relation::class;
    }

    /**
     * Undocumented function
     *
     * @param Model $model
     * @param array $data
     * @return void
     */
    public function update(Model $model, array $data): void
    {
        Store::of($this->getStore())->update($data, $model->{$this->key()});
    }
}
