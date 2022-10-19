<?php

namespace LaravelGreatApi\Eloquent\Store\Relations;

/**
 * @method mixed create($model, $data)
 * @method mixed update($model, $data)
 * @method mixed store()
 * @property string $store
 */
class Relation
{
    public function key()
    {
        return $this->key;
    }

    public function column()
    {
        return $this->column;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function setData($data)
    {
        return $this->data = $data;
    }
}
